<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Service;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdersController extends Controller
{
    public function __construct()
    {
        // Setup Midtrans config
        Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized  = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds        = env('MIDTRANS_IS_3DS', true);
    }

    // Halaman form order (customer isi data diri)
    public function create(Service $service)
    {
        return view('orders.create', compact('service'));
    }

    // Simpan order & ambil snap token
    public function store(Request $request, Service $service)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:20',
        ]);

        $orderId = 'ORDER-' . strtoupper(uniqid());

        // Buat order di database
        $order = Orders::create([
            'order_id'       => $orderId,
            'service_id'     => $service->id,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price'    => $service->price,
            'status'         => 'pending',
        ]);

        // Siapkan payload untuk Midtrans Snap
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $service->price,
            ],
            'item_details' => [
                [
                    'id'       => $service->id,
                    'price'    => (int) $service->price,
                    'quantity' => 1,
                    'name'     => $service->name,
                ]
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email'      => $request->customer_email,
                'phone'      => $request->customer_phone,
            ],
        ];

        // Ambil snap token dari Midtrans
        $snapToken = Snap::getSnapToken($params);

        // Simpan snap token ke order
        $order->update(['snap_token' => $snapToken]);

        return view('orders.payment', compact('order', 'snapToken', 'service'));
    }

    // Callback dari Midtrans (notification URL)
    public function callback(Request $request)
    {
        $serverKey       = env('MIDTRANS_SERVER_KEY');
        $hashed          = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        // Validasi signature key
        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Orders::where('order_id', $request->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update status berdasarkan transaction_status dari Midtrans
        $transactionStatus = $request->transaction_status;
        $fraudStatus       = $request->fraud_status;

        if ($transactionStatus === 'capture' && $fraudStatus === 'accept') {
            $order->update(['status' => 'paid']);
        } elseif ($transactionStatus === 'settlement') {
            $order->update(['status' => 'paid']);
        } elseif (in_array($transactionStatus, ['cancel', 'deny'])) {
            $order->update(['status' => 'failed']);
        } elseif ($transactionStatus === 'expire') {
            $order->update(['status' => 'expired']);
        } elseif ($transactionStatus === 'pending') {
            $order->update(['status' => 'pending']);
        }

        return response()->json(['message' => 'OK']);
    }

    // Halaman sukses setelah bayar
    public function success(Request $request)
    {
        $order = Orders::where('order_id', $request->order_id)->first();

        // Jika order masih pending, aktif cek ke Midtrans API
        // agar tidak tergantung pada callback async yang mungkin belum tiba
        if ($order && $order->status === 'pending') {
            try {
                $midtransStatus = Transaction::status($order->order_id);
                $txStatus    = $midtransStatus->transaction_status ?? null;
                $fraudStatus = $midtransStatus->fraud_status ?? null;

                if (
                    in_array($txStatus, ['capture', 'settlement']) &&
                    ($fraudStatus === 'accept' || $txStatus === 'settlement')
                ) {
                    $order->update(['status' => 'paid']);
                } elseif (in_array($txStatus, ['cancel', 'deny'])) {
                    $order->update(['status' => 'failed']);
                } elseif ($txStatus === 'expire') {
                    $order->update(['status' => 'expired']);
                }

                // Reload dari DB agar status terbaru
                $order->refresh();
            } catch (\Exception $e) {
                // Biarkan status tetap pending jika Midtrans API gagal dipanggil
            }
        }

        return view('orders.success', compact('order'));
    }

    // Cek status order secara real-time (untuk polling dari frontend)
    public function checkStatus(Orders $order)
    {
        return response()->json([
            'status'   => $order->status,
            'order_id' => $order->order_id,
        ]);
    }

    // Daftar semua order (admin)
    public function index()
    {
        $orders = Orders::with('service')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function invoice(Orders $order)
    {
        if ($order->status !== 'paid') {
            return redirect()->back()->with('error', 'Invoice hanya tersedia untuk order yang sudah dibayar.');
        }

        $pdf = Pdf::loadView('orders.invoice', compact('order'))
            ->setPaper('a4', 'portrait')
            ->setOption([
                'dpi' => 96,
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'margin_left' => 10,
                'margin_right' => 10,
            ]);

        return $pdf->download('invoice-' . $order->order_id . '.pdf');
    }
}

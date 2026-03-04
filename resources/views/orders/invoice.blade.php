<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body {
            font-family: 'DejaVu Sans', sans-serif;
            background: #fff;
            color: #1a1a1a;
            font-size: 13px;
        }
        .container { padding: 40px; }

        /* Header */
        .header { display: table; width: 100%; margin-bottom: 40px; }
        .header-left { display: table-cell; vertical-align: middle; }
        .header-right { display: table-cell; vertical-align: middle; text-align: right; }
        .logo { font-size: 28px; font-weight: 900; color: #8B0000; letter-spacing: 3px; }
        .company { font-size: 10px; color: #888; margin-top: 2px; letter-spacing: 1px; }
        .invoice-title { font-size: 22px; font-weight: 900; color: #1a1a1a; }
        .invoice-number { font-size: 11px; color: #888; margin-top: 2px; }

        /* Divider */
        .divider { height: 2px; background: #8B0000; margin-bottom: 30px; }
        .divider-thin { height: 1px; background: #eee; margin: 20px 0; }

        /* Status badge */
        .badge-paid { display: inline-block; background: #dcfce7; color: #16a34a; font-size: 10px; font-weight: 900; padding: 4px 12px; border-radius: 99px; letter-spacing: 1px; text-transform: uppercase; }

        /* Info section */
        .info-table { display: table; width: 100%; margin-bottom: 30px; }
        .info-left { display: table-cell; width: 50%; vertical-align: top; }
        .info-right { display: table-cell; width: 50%; vertical-align: top; text-align: right; }
        .info-label { font-size: 10px; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .info-value { font-size: 13px; font-weight: 700; color: #1a1a1a; }
        .info-sub { font-size: 11px; color: #555; margin-top: 2px; }

        /* Items table */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table thead tr { background: #8B0000; color: white; }
        .items-table thead th { padding: 10px 14px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; text-align: left; }
        .items-table thead th:last-child { text-align: right; }
        .items-table tbody tr { border-bottom: 1px solid #f1f1f1; }
        .items-table tbody td { padding: 12px 14px; font-size: 13px; color: #333; }
        .items-table tbody td:last-child { text-align: right; font-weight: 700; }

        /* Total */
        .total-table { display: table; width: 100%; }
        .total-right { display: table-cell; text-align: right; width: 100%; }
        .total-row { margin-bottom: 6px; }
        .total-label { font-size: 12px; color: #888; }
        .total-value { font-size: 12px; color: #333; font-weight: 600; margin-left: 20px; }
        .grand-total-label { font-size: 14px; font-weight: 900; color: #8B0000; }
        .grand-total-value { font-size: 16px; font-weight: 900; color: #8B0000; margin-left: 20px; }

        /* Footer */
        .footer { margin-top: 50px; text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #eee; padding-top: 16px; }
    </style>
</head>
<body>
<div class="container">

    {{-- Header --}}
    <div class="header">
        <div class="header-left">
            <div class="logo">KYB</div>
            <div class="company">Kayaba Training Center</div>
        </div>
        <div class="header-right">
            <div class="invoice-title">INVOICE</div>
            <div class="invoice-number"># {{ $order->order_id }}</div>
            <div style="margin-top:6px;">
                <span class="badge-paid">✓ PAID</span>
            </div>
        </div>
    </div>

    <div class="divider"></div>

    {{-- Info --}}
    <div class="info-table">
        <div class="info-left">
            <div class="info-label">Tagihan Kepada</div>
            <div class="info-value">{{ $order->customer_name }}</div>
            <div class="info-sub">{{ $order->customer_email }}</div>
            @if($order->customer_phone)
            <div class="info-sub">{{ $order->customer_phone }}</div>
            @endif
        </div>
        <div class="info-right">
            <div class="info-label">Tanggal</div>
            <div class="info-value">{{ $order->created_at->format('d M Y') }}</div>
            <div class="info-sub" style="margin-top:12px;">
                <span class="info-label">Metode Pembayaran</span>
            </div>
            <div class="info-value">Midtrans</div>
        </div>
    </div>

    <div class="divider-thin"></div>

    {{-- Items --}}
    <table class="items-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $order->service->name }}</strong>
                    @if($order->service->description)
                    <br><span style="font-size:11px;color:#888;">{{ $order->service->description }}</span>
                    @endif
                </td>
                <td>1</td>
                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="divider-thin"></div>

    {{-- Total --}}
    <div class="total-table">
        <div class="total-right">
            <div class="total-row">
                <span class="grand-total-label">TOTAL</span>
                <span class="grand-total-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        Terima kasih telah menggunakan layanan KYB Training Center
    </div>

</div>
</body>
</html>

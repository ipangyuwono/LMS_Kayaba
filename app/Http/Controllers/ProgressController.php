<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerProgress;
use App\Models\Material;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    // Daftar semua customer + ringkasan progress
    public function index()
    {
        $customers = Customer::withCount([
            'progress',
            'progress as completed_count' => function ($q) {
                $q->where('status', 'completed');
            },
            'progress as in_progress_count' => function ($q) {
                $q->where('status', 'in_progress');
            },
        ])->paginate(15);

        $totalMaterials = Material::where('is_active', true)->count();

        return view('progress.index', compact('customers', 'totalMaterials'));
    }

    // Detail progress per customer
    public function show(Customer $customer)
    {
        // Ambil semua materi aktif, grouped by service
        $materials = Material::with('service')
            ->where('is_active', true)
            ->orderBy('service_id')
            ->orderBy('position')
            ->get();

        // Ambil progress yang sudah ada untuk customer ini
        $progressMap = CustomerProgress::where('customer_id', $customer->id)
            ->pluck('status', 'material_id')
            ->toArray();

        return view('progress.show', compact('customer', 'materials', 'progressMap'));
    }

    // Update status progress
    public function updateStatus(Request $request, CustomerProgress $progress)
    {
        $request->validate([
            'status' => 'required|in:not_started,in_progress,completed',
        ]);

        $now = now();
        $data = ['status' => $request->status];

        if ($request->status === 'in_progress' && !$progress->started_at) {
            $data['started_at'] = $now;
        }
        if ($request->status === 'completed') {
            $data['completed_at'] = $now;
            if (!$progress->started_at) {
                $data['started_at'] = $now;
            }
        }
        if ($request->status === 'not_started') {
            $data['started_at']   = null;
            $data['completed_at'] = null;
        }

        $progress->update($data);

        return redirect()->back()->with('success', 'Status progress berhasil diperbarui.');
    }

    // Toggle / create progress entry (untuk assign materi ke customer)
    public function toggle(Request $request, Customer $customer)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'status'      => 'required|in:not_started,in_progress,completed',
        ]);

        $now = now();
        $data = ['status' => $request->status];

        if ($request->status === 'in_progress') {
            $data['started_at'] = $now;
        } elseif ($request->status === 'completed') {
            $data['started_at']   = $now;
            $data['completed_at'] = $now;
        }

        CustomerProgress::updateOrCreate(
            [
                'customer_id' => $customer->id,
                'material_id' => $request->material_id,
            ],
            $data
        );

        return redirect()->back()->with('success', 'Progress berhasil diperbarui.');
    }
}

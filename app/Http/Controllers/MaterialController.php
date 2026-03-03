<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('service')->orderBy('service_id')->orderBy('position')->paginate(15);
        $services  = Service::where('is_active', true)->orderBy('name')->get();
        return view('materials.index', compact('materials', 'services'));
    }

    private function validateMaterial(Request $request): array
    {
        $mimeMap = [
            'pdf'      => 'pdf',
            'video'    => 'mp4,mkv,avi,mov',
            'document' => 'doc,docx,ppt,pptx,xls,xlsx',
        ];

        $fileRule = 'nullable|file|max:51200';
        if (isset($mimeMap[$request->type])) {
            $fileRule .= '|mimes:' . $mimeMap[$request->type];
        }

        return $request->validate([
            'service_id'  => 'required|exists:services,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:video,pdf,document,link',
            'file'        => $fileRule,
            'url'         => 'nullable|url|max:500',
            'position'    => 'nullable|integer|min:0',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateMaterial($request);

        $data = collect($validated)->only(['service_id', 'title', 'description', 'type', 'url', 'position'])->toArray();
        $data['is_active'] = $request->boolean('is_active');
        $data['position']  = $data['position'] ?? 0;

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('materials', 'public');
        }

        Material::create($data);

        return redirect()->route('materials.index')
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function update(Request $request, Material $material)
    {
        $validated = $this->validateMaterial($request);

        $data = collect($validated)->only(['service_id', 'title', 'description', 'type', 'url', 'position'])->toArray();
        $data['is_active'] = $request->boolean('is_active');
        $data['position']  = $data['position'] ?? 0;

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $data['file_path'] = $request->file('file')->store('materials', 'public');
        }

        $material->update($data);

        return redirect()->route('materials.index')
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('materials.index')
            ->with('success', 'Materi berhasil dihapus.');
    }
}

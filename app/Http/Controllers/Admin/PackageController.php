<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('sort_order')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatePackage($request);
        $data = $this->preparePackageData($request, $data);

        Package::create($data);

        return redirect()->route('admin.packages.index')
            ->with('success', 'تم إضافة الباقة بنجاح');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $data = $this->validatePackage($request);
        $data = $this->preparePackageData($request, $data);

        $package->update($data);

        return redirect()->route('admin.packages.index')
            ->with('success', 'تم تحديث الباقة بنجاح');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'تم حذف الباقة بنجاح');
    }

    private function validatePackage(Request $request): array
    {
        return $request->validate([
            'icon'           => 'nullable|string|max:100',
            'name'           => 'required|string|max:255',
            'name_en'        => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'description_en' => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'currency'       => 'required|string|max:10',
            'badge'          => 'nullable|string|max:100',
            'badge_en'       => 'nullable|string|max:100',
            'sort_order'     => 'nullable|integer|min:0',
            'features'       => 'required|array|min:1',
            'features.*'     => 'required|string|max:255',
            'features_en'    => 'nullable|array',
            'features_en.*'  => 'nullable|string|max:255',
        ]);
    }

    private function preparePackageData(Request $request, array $data): array
    {
        $featuresAr = array_values(array_filter(
            array_map('trim', $data['features'] ?? []),
            fn($item) => $item !== ''
        ));

        $featuresEnRaw = $data['features_en'] ?? [];
        $featuresEn = [];
        foreach ($featuresAr as $index => $arItem) {
            $enItem = trim($featuresEnRaw[$index] ?? '');
            $featuresEn[] = $enItem !== '' ? $enItem : $arItem;
        }

        $data['icon'] = trim($data['icon'] ?? '') ?: 'fas fa-box-open';
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['features'] = $featuresAr;
        $data['features_en'] = $featuresEn;

        return $data;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->latest('id')->get();

        return view('admin.hero_slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.hero_slides.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image'      => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'title'      => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['image']      = $request->file('image')->store('hero-slides', 'public');
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        HeroSlide::create($data);

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('success', 'تم إضافة صورة السلايدر بنجاح');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero_slides.edit', compact('heroSlide'));
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $data = $request->validate([
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'title'      => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($heroSlide->image && Storage::disk('public')->exists($heroSlide->image)) {
                Storage::disk('public')->delete($heroSlide->image);
            }

            $data['image'] = $request->file('image')->store('hero-slides', 'public');
        }

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $heroSlide->update($data);

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('success', 'تم تحديث صورة السلايدر بنجاح');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->image && Storage::disk('public')->exists($heroSlide->image)) {
            Storage::disk('public')->delete($heroSlide->image);
        }

        $heroSlide->delete();

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('success', 'تم حذف صورة السلايدر بنجاح');
    }
}

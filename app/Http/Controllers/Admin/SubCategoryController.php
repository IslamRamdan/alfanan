<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        // جلب الأقسام الفرعية مع القسم الرئيسي لتقليل الاستعلامات (Eager Loading)
        $subCategories = SubCategory::with('category')->latest()->paginate(10);
        return view('admin.sub_categories.index', compact('subCategories'));
    }

    public function create()
    {
        // جلب الأقسام الرئيسية لاختيار أحدها عند إضافة قسم فرعي
        $categories = Category::all();
        return view('admin.sub_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name_ar.required' => 'يرجى إدخال اسم القسم الفرعي بالعربية',
            'name_en.required' => 'يرجى إدخال اسم القسم الفرعي بالإنجليزية',
            'category_id.required' => 'يرجى اختيار القسم الرئيسي',
            'category_id.exists' => 'القسم الرئيسي المختار غير موجود',
        ]);

        SubCategory::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.sub-categories.index')->with('success', 'تم إضافة القسم الفرعي بنجاح');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::all();
        return view('admin.sub_categories.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name_ar.required' => 'يرجى إدخال اسم القسم الفرعي بالعربية',
            'name_en.required' => 'يرجى إدخال اسم القسم الفرعي بالإنجليزية',
            'category_id.required' => 'يرجى اختيار القسم الرئيسي',
            'category_id.exists' => 'القسم الرئيسي المختار غير موجود',
        ]);

        $subCategory->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.sub-categories.index')->with('success', 'تم تحديث القسم الفرعي بنجاح');
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        return redirect()->route('admin.sub-categories.index')->with('success', 'تم حذف القسم الفرعي بنجاح');
    }
}

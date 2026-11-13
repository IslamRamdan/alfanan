<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // 1. عرض جميع المدونات
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    // 2. صفحة إضافة مدونة جديدة
    public function create()
    {
        return view('admin.blogs.create');
    }

    // 3. تخزين المدونة الجديدة في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'meta_title_ar' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_ar' => 'nullable|string',
            'meta_description_en' => 'nullable|string',
            'meta_keywords_ar' => 'nullable|string',
            'meta_keywords_en' => 'nullable|string',
        ]);

        // رفع الصورة
        $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
        $request->file('image')->move(public_path('uploads/blogs'), $imageName);
        $imagePath = 'uploads/blogs/' . $imageName;

        // إنشاء المدونة
        Blog::create([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'image' => $imagePath,
            'meta_title_ar' => $request->meta_title_ar,
            'meta_title_en' => $request->meta_title_en,
            'meta_description_ar' => $request->meta_description_ar,
            'meta_description_en' => $request->meta_description_en,
            'meta_keywords_ar' => $request->meta_keywords_ar,
            'meta_keywords_en' => $request->meta_keywords_en,
            'slug' => Str::slug($request->title_en),
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'تم إضافة المدونة بنجاح');
    }

    // 4. صفحة تعديل المدونة
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    // 5. تحديث المدونة
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'meta_title_ar' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_ar' => 'nullable|string',
            'meta_description_en' => 'nullable|string',
            'meta_keywords_ar' => 'nullable|string',
            'meta_keywords_en' => 'nullable|string',
        ]);

        $imagePath = $blog->image;

        // إذا تم رفع صورة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($blog->image && file_exists(public_path($blog->image))) {
                @unlink(public_path($blog->image));
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/blogs'), $imageName);
            $imagePath = 'uploads/blogs/' . $imageName;
        }

        // تحديث البيانات
        $blog->update([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'image' => $imagePath,
            'meta_title_ar' => $request->meta_title_ar,
            'meta_title_en' => $request->meta_title_en,
            'meta_description_ar' => $request->meta_description_ar,
            'meta_description_en' => $request->meta_description_en,
            'meta_keywords_ar' => $request->meta_keywords_ar,
            'meta_keywords_en' => $request->meta_keywords_en,
            'slug' => Str::slug($request->title_en),
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'تم تحديث المدونة بنجاح');
    }

    // 6. حذف المدونة
    public function destroy(Blog $blog)
    {
        // حذف الصورة من الفولدر
        if ($blog->image && file_exists(public_path($blog->image))) {
            @unlink(public_path($blog->image));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'تم حذف المدونة بنجاح');
    }

    public function mdwna()
    {
        $blogs = Blog::get();
        $categories = \App\Models\Category::with('subCategories')->get(); // جلب الأقسام الرئيسية مع الأقسام الفرعية

        // return $blogs;
        return view('mdwna', compact('blogs', 'categories'));
    }
    public function show(Blog $blog)
    {
        $categories = \App\Models\Category::with('subCategories')->get(); // جلب الأقسام الرئيسية مع الأقسام الفرعية

        return view('blog-show', compact('blog', 'categories'));
    }
}

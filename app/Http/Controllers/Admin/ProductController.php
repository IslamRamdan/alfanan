<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('subCategory', 'images', 'specifications')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $subCategories = SubCategory::all();
        return view('admin.products.create', compact('subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // الصورة الرئيسية
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // الصور الفرعية
            'specs.*.key_ar' => 'nullable|string|max:255',
            'specs.*.key_en' => 'nullable|string|max:255',
            'specs.*.value_ar' => 'nullable|string|max:255',
            'specs.*.value_en' => 'nullable|string|max:255',
        ]);

        // 1. رفع الصورة الأساسية
        $mainImageName = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
        $request->file('image')->move(public_path('uploads/products'), $mainImageName);

        // 2. إنشاء المنتج
        $product = Product::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'price' => $request->price,
            'image' => 'uploads/products/' . $mainImageName,
            'sub_category_id' => $request->sub_category_id,
        ]);

        // 3. رفع وحفظ الصور الفرعية (إن وجدت)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $subImageName = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move(public_path('uploads/products/gallery'), $subImageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'uploads/products/gallery/' . $subImageName,
                ]);
            }
        }

        // 4. حفظ المواصفات متعددة اللغات
        if ($request->has('specs')) {
            foreach ($request->specs as $spec) {
                if (!empty($spec['key_ar']) || !empty($spec['key_en']) || !empty($spec['value_ar']) || !empty($spec['value_en'])) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'key_ar' => $spec['key_ar'] ?? '',
                        'key_en' => $spec['key_en'] ?? '',
                        'value_ar' => $spec['value_ar'] ?? '',
                        'value_en' => $spec['value_en'] ?? '',
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function edit(Product $product)
    {
        $subCategories = SubCategory::all();
        // تحميل العلاقات عشان تظهر في الفورم
        $product->load('images', 'specifications');
        return view('admin.products.edit', compact('product', 'subCategories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // الصورة الرئيسية اختيارية عند التعديل
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'specs.*.key_ar' => 'nullable|string|max:255',
            'specs.*.key_en' => 'nullable|string|max:255',
            'specs.*.value_ar' => 'nullable|string|max:255',
            'specs.*.value_en' => 'nullable|string|max:255',
        ]);

        // 1. تحديث الصورة الأساسية (إذا تم رفع صورة جديدة)
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة من الفولدر
            if ($product->image && file_exists(public_path($product->image))) {
                @unlink(public_path($product->image));
            }

            $mainImageName = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/products'), $mainImageName);
            $product->image = 'uploads/products/' . $mainImageName;
        }

        // 2. تحديث بيانات المنتج الأساسية
        $product->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'price' => $request->price,
            'image' => $product->image,
            'sub_category_id' => $request->sub_category_id,
        ]);

        // 3. إضافة صور فرعية جديدة (إن وجدت)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $subImageName = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move(public_path('uploads/products/gallery'), $subImageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'uploads/products/gallery/' . $subImageName,
                ]);
            }
        }

        // 4. تحديث المواصفات (حذف القديم وإعادة إدخال الموجود)
        $product->specifications()->delete();
        if ($request->has('specs')) {
            foreach ($request->specs as $spec) {
                if (!empty($spec['key_ar']) || !empty($spec['key_en']) || !empty($spec['value_ar']) || !empty($spec['value_en'])) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'key_ar' => $spec['key_ar'] ?? '',
                        'key_en' => $spec['key_en'] ?? '',
                        'value_ar' => $spec['value_ar'] ?? '',
                        'value_en' => $spec['value_en'] ?? '',
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function destroy(Product $product)
    {
        // حذف الصورة الرئيسية
        if ($product->image && file_exists(public_path($product->image))) {
            @unlink(public_path($product->image));
        }

        // حذف الصور الفرعية من الفولدر
        foreach ($product->images as $img) {
            if ($img->image && file_exists(public_path($img->image))) {
                @unlink(public_path($img->image));
            }
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج بنجاح');
    }
    public function products(Request $request)
    {
        $categories = Category::with('subCategories')->get();

        $query = Product::with('subCategory');

        // فلترة بالقسم الرئيسي (كل المنتجات التابعة لأقسامه الفرعية)
        if ($request->filled('category')) {
            $query->whereHas('subCategory', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        // فلترة بالقسم الفرعي
        if ($request->filled('sub_category')) {
            $query->where('sub_category_id', $request->sub_category);
        }

        // البحث
        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('name_ar', 'like', "%{$term}%")
                    ->orWhere('name_en', 'like', "%{$term}%")
                    ->orWhere('description_ar', 'like', "%{$term}%")
                    ->orWhere('description_en', 'like', "%{$term}%");
            });
        }

        // الترتيب
        switch ($request->sort) {
            case 'price-low':
                $query->orderBy('price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name_ar', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        // العنوان والوصف حسب الفلتر الحالي
        $currentCategory = $request->filled('category') ? Category::find($request->category) : null;
        $currentSubCategory = $request->filled('sub_category') ? SubCategory::find($request->sub_category) : null;

        return view('products', compact('products', 'categories', 'currentCategory', 'currentSubCategory'));
    }
    public function showProduct(Product $product)
    {
        $product->load('subCategory.category', 'images', 'specifications');
        // return $product;

        $categories = Category::with('subCategories')->get();

        $related = Product::with('subCategory')
            ->where('id', '!=', $product->id)
            ->when($product->sub_category_id, fn($q) => $q->where('sub_category_id', $product->sub_category_id))
            ->latest()
            ->take(4)
            ->get();

        return view('product-show', compact('product', 'categories', 'related'));
    }
    public function marketing()
    {
        $categories = Category::with('subCategories')->get(); // نفس استعلام الرئيسية
        return view('marketing', compact('categories'));
    }
}

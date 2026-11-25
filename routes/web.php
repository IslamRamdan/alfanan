<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SiteLinkController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Package;
use App\Models\Product;
use App\Models\SiteLink;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\returnArgument;

Route::get('/', function () {

    // جلب الأقسام الرئيسية ومعها الأقسام الفرعية المرتبطة بها
    $categories = Category::with('subCategories')->get();
    $packages = Package::where('is_active', true)->orderBy('sort_order')->get();
    $slides = HeroSlide::where('is_active', true)->orderBy('sort_order')->get();
    $clients = \App\Models\Client::where('is_active', true)->orderBy('sort_order')->get();
    $siteLink = SiteLink::first();    // return $siteLinks;

    return view('welcome', compact('categories', 'packages', 'slides', 'clients', 'siteLink'));
});

Route::get('/dashboard', function () {
    $categoriesCount = Category::count();
    $subCategoriesCount = SubCategory::count();
    $productsCount = Product::count();
    $totalInventoryValue = Product::sum('price'); // إجمالي قيمة المنتجات أو الأقسام حسب رغبتك

    // أحدث 5 منتجات مضافة
    $latestProducts = Product::with('subCategory')->latest()->take(5)->get();

    return view('dashboard', compact(
        'categoriesCount',
        'subCategoriesCount',
        'productsCount',
        'totalInventoryValue',
        'latestProducts'
    ));
})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('sub-categories', SubCategoryController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
});
Route::delete('product-images/{id}', function ($id) {
    $img = \App\Models\ProductImage::findOrFail($id);
    if ($img->image && file_exists(public_path($img->image))) {
        @unlink(public_path($img->image));
    }
    $img->delete();
    return back()->with('success', 'تم حذف الصورة بنجاح');
})->name('admin.product-images.destroy');

Route::get('/products', [ProductController::class, 'products'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'showProduct'])->name('products.show');
Route::get('/marketing', [ProductController::class, 'marketing'])->name('marketing');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('blogs', BlogController::class);
});


Route::get('/blogs', [BlogController::class, 'mdwna'])->name('blogs.index');
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('packages', PackageController::class)->except(['show']);
    Route::resource('hero-slides', HeroSlideController::class)->except(['show']);
    Route::resource('clients', ClientController::class);
    Route::get('site-links', [SiteLinkController::class, 'index'])->name('site-links.index');
    Route::put('site-links', [SiteLinkController::class, 'update'])->name('site-links.update');
});
require __DIR__ . '/auth.php';

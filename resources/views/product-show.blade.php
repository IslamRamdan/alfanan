@php
    $nameAr = $product->name_ar;
    $nameEn = $product->name_en ?: $product->name_ar;
    $descAr = $product->description_ar;
    $descEn = $product->description_en ?: $product->description_ar;

    $subCat = $product->subCategory;
    $catAr = $subCat->name_ar ?? '';
    $catEn = $subCat->name_en ?? '' ?: $catAr;

    // كل الصور: الرئيسية + الفرعية
    $gallery = collect([$product->image])
        ->merge($product->images->pluck('image'))
        ->filter()
        ->values();

    $totalImages = max($gallery->count(), 1);

    $jsProduct = [
        'id' => $product->id,
        'name_ar' => $nameAr,
        'name_en' => $nameEn,
        'category_ar' => $catAr,
        'category_en' => $catEn,
        'price' => number_format($product->price, 2),
        'url' => url()->current(),
    ];

    $jsImages = $gallery
        ->map(function ($img) {
            return asset($img);
        })
        ->values()
        ->all();
@endphp
<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $product->name_ar }} | الفنان</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
</head>

<body>

    <div class="alf-topbar">
        <div class="alf-topbar-container">

            <div class="alf-topbar-search">
                <i class="fas fa-search"></i>
                <input type="search" id="siteSearch" data-ar-placeholder="ابحث عن منتج أو خدمة..."
                    data-en-placeholder="Search for a product or service..." placeholder="ابحث عن منتج أو خدمة...">
            </div>

            <div class="alf-topbar-delivery">
                <i class="fas fa-truck-fast"></i>
                <span>
                    <span data-ar="توصيل مجاني داخل مكة لأي طلب فوق"
                        data-en="Free delivery within Makkah for orders over">توصيل مجاني داخل مكة لأي طلب فوق</span>
                    <strong data-ar="500 ريال" data-en="500 SAR">500 ريال</strong>
                </span>
            </div>

            <button class="alf-theme-toggle" id="themeToggle" aria-label="Change theme">
                <i class="fas fa-moon"></i>
            </button>

        </div>
    </div>

    <div class="language-switcher" id="languageSwitcher">
        <button class="language-switcher-btn" id="languageSwitcherBtn" type="button" aria-label="Change language"
            aria-expanded="false" aria-controls="languageSwitcherMenu">
            <span class="language-current-flag" id="currentLangFlag">🇸🇦</span>
            <span class="language-current-code" id="currentLangCode">AR</span>
            <i class="fa-solid fa-chevron-up"></i>
        </button>

        <div class="language-switcher-menu" id="languageSwitcherMenu">
            <button type="button" class="language-option active" data-lang="ar">
                <span>🇸🇦</span>
                <span>العربية</span>
                <i class="fa-solid fa-check"></i>
            </button>

            <button type="button" class="language-option" data-lang="en">
                <span>🇺🇸</span>
                <span>English</span>
                <i class="fa-solid fa-check"></i>
            </button>
        </div>
    </div>

    <header class="site-header">
        <div class="header-inner">

            <a href="{{ url('/') }}" class="d-flex flex-row" aria-label="الرئيسية">
                <img src="{{ asset('images/logo-2.png') }}" height="40" alt="">
                <img src="{{ asset('images/logo-3.png') }}" height="40" alt="">
            </a>

            <button class="mobile-toggle" id="mobileToggle" type="button" aria-label="فتح القائمة"
                aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="main-nav" id="mainNav">

                <a href="{{ url('/') }}" class="nav-link">
                    <span data-ar="الرئيسية" data-en="Home">الرئيسية</span>
                </a>

                @foreach ($categories as $category)
                    <div class="nav-dropdown">
                        <button class="nav-link dropdown-trigger" type="button" aria-expanded="false">
                            <span data-ar="{{ $category->name_ar }}"
                                data-en="{{ $category->name_en ?: $category->name_ar }}">
                                {{ $category->name_ar }}
                            </span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>

                        <div class="mega-menu">
                            <div class="mega-menu-content">
                                <a class="mega-label"
                                    href="{{ route('products.index', ['category' => $category->id]) }}"
                                    data-ar="{{ $category->name_ar }}"
                                    data-en="{{ $category->name_en ?: $category->name_ar }}">
                                    {{ $category->name_ar }}
                                </a>

                                @foreach ($category->subCategories as $subCategory)
                                    <a href="{{ route('products.index', ['sub_category' => $subCategory->id]) }}">
                                        <i class="fa-solid fa-circle-dot"></i>
                                        <span data-ar="{{ $subCategory->name_ar }}"
                                            data-en="{{ $subCategory->name_en ?: $subCategory->name_ar }}">
                                            {{ $subCategory->name_ar }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                <a href="{{ route('blogs.index') }}" class="nav-link ">
                    <span data-ar="المدونة" data-en="Blog">المدونة</span>
                </a>

                <a href="{{ route('marketing') }}" class="nav-link">
                    <span data-ar="التسويق والبرمجة" data-en="Marketing & Programming">التسويق والبرمجة</span>
                </a>

            </nav>
        </div>
    </header>

    <main>

        {{-- ===================== Breadcrumb ===================== --}}
        <section class="alf-detail-breadcrumb-section">
            <div class="container py-5">
                <div class="alf-detail-breadcrumb-inner py-5">
                    <div>
                        <span class="alf-detail-eyebrow">
                            <i class="fas fa-gem"></i>
                            <span data-ar="منتجات الفنان المميزة" data-en="Al Fannan Featured Products">منتجات الفنان
                                المميزة</span>
                        </span>

                        <h1 id="alfBreadcrumbTitle" data-ar="تفاصيل المنتج" data-en="Product Details">
                            تفاصيل المنتج
                        </h1>

                        <p data-ar="تفاصيل دقيقة وجودة تنفيذ تليق بمناسباتك وأعمالك."
                            data-en="Precise details and exceptional craftsmanship to complement your occasions and business needs.">
                            تفاصيل دقيقة وجودة تنفيذ تليق بمناسباتك وأعمالك.
                        </p>
                    </div>

                    <nav class="alf-detail-breadcrumb" aria-label="مسار التنقل">
                        <a href="{{ url('/') }}" data-ar="الرئيسية" data-en="Home">الرئيسية</a>
                        <i class="fas fa-chevron-left"></i>
                        <a href="{{ route('products.index') }}" data-ar="المنتجات" data-en="Products">المنتجات</a>
                        <i class="fas fa-chevron-left"></i>
                        <span id="alfBreadcrumbCurrent" data-ar="{{ $nameAr }}"
                            data-en="{{ $nameEn }}">{{ $nameAr }}</span>
                    </nav>
                </div>
            </div>
        </section>

        {{-- ===================== تفاصيل المنتج ===================== --}}
        <section class="alf-detail-product-section">
            <div class="container">
                <div class="row g-4 align-items-start">

                    {{-- ---------- المعرض + التابات ---------- --}}
                    <div class="col-lg-6">
                        <div class="alf-detail-gallery">
                            <div class="alf-detail-main-image-wrap">

                                <div class="alf-detail-gallery-badge">
                                    <i class="fas fa-images"></i>
                                    <span data-ar="معرض صور المنتج" data-en="Product Image Gallery">معرض صور
                                        المنتج</span>
                                </div>

                                <img id="alfDetailMainImage" class="alf-detail-main-image"
                                    src="{{ asset($gallery->first()) }}" alt="{{ $nameAr }}">

                                <button type="button" class="alf-detail-zoom" id="alfDetailZoom"
                                    aria-label="تكبير الصورة">
                                    <i class="fas fa-expand"></i>
                                </button>

                                @if ($gallery->count() > 1)
                                    <button type="button" class="alf-detail-gallery-arrow alf-detail-gallery-prev"
                                        id="alfDetailPrev" aria-label="الصورة السابقة">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>

                                    <button type="button" class="alf-detail-gallery-arrow alf-detail-gallery-next"
                                        id="alfDetailNext" aria-label="الصورة التالية">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                @endif

                                <div class="alf-detail-image-counter">
                                    <span id="alfDetailCurrentImage">01</span>
                                    <span>/</span>
                                    <span
                                        id="alfDetailTotalImages">{{ str_pad($totalImages, 2, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>

                            @if ($gallery->count() > 1)
                                <div class="alf-detail-thumbnails" id="alfDetailThumbnails">
                                    @foreach ($gallery as $i => $img)
                                        <button type="button"
                                            class="alf-detail-thumbnail {{ $i === 0 ? 'active' : '' }}"
                                            data-src="{{ asset($img) }}" aria-label="صورة {{ $i + 1 }}">
                                            <img src="{{ asset($img) }}"
                                                alt="{{ $nameAr }} - {{ $i + 1 }}">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div>
                            <div class="alf-detail-tabs">
                                <button type="button" class="active" data-tab="description" aria-selected="true">
                                    <i class="fas fa-align-right"></i>
                                    <span data-ar="وصف المنتج" data-en="Product Description">وصف المنتج</span>
                                </button>

                                <button type="button" data-tab="specifications" aria-selected="false">
                                    <i class="fas fa-list-check"></i>
                                    <span data-ar="المواصفات" data-en="Specifications">المواصفات</span>
                                </button>

                                <button type="button" data-tab="ordering" aria-selected="false">
                                    <i class="fas fa-truck-fast"></i>
                                    <span data-ar="طريقة الطلب" data-en="How to Order">طريقة الطلب</span>
                                </button>
                            </div>

                            {{-- وصف المنتج --}}
                            <div class="alf-detail-tab-content active" id="alfTab-description">
                                <div class="row align-items-center g-4">
                                    <div class="col-lg-8">
                                        <span class="alf-detail-section-eyebrow" data-ar="تفاصيل المنتج"
                                            data-en="Product Details">تفاصيل المنتج</span>

                                        <h2>
                                            <span data-ar="تفاصيل تبرز" data-en="Details That Highlight">تفاصيل
                                                تبرز</span>
                                            <span data-ar="جمال التصميم" data-en="Design Elegance">جمال التصميم</span>
                                        </h2>

                                        @if ($descAr)
                                            <p id="alfDetailFullDescription" data-ar="{{ $descAr }}"
                                                data-en="{{ $descEn }}">{{ $descAr }}</p>
                                        @endif

                                        <p data-ar="في شركة الفنان للدعاية والإعلان، نهتم بتقديم منتجات دعائية وتذكارية تتناسب مع هوية العميل وطبيعة المناسبة، مع إمكانية مناقشة المقاسات والتصميم والتفاصيل قبل التنفيذ."
                                            data-en="At Al Fannan Advertising Company, we are committed to providing promotional and commemorative products that match each client's identity and occasion. Sizes, designs, and other details can be discussed before production.">
                                            في شركة الفنان للدعاية والإعلان، نهتم بتقديم منتجات دعائية وتذكارية تتناسب
                                            مع
                                            هوية العميل وطبيعة المناسبة، مع إمكانية مناقشة المقاسات والتصميم والتفاصيل
                                            قبل
                                            التنفيذ.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- المواصفات --}}
                            <div class="alf-detail-tab-content" id="alfTab-specifications">
                                @if ($product->specifications->count())
                                    <div class="alf-detail-specifications mb-3">
                                        @foreach ($product->specifications as $spec)
                                            <div>
                                                <span data-ar="{{ $spec->key_ar }}"
                                                    data-en="{{ $spec->key_en ?: $spec->key_ar }}">{{ $spec->key_ar }}</span>
                                                <strong data-ar="{{ $spec->value_ar }}"
                                                    data-en="{{ $spec->value_en ?: $spec->value_ar }}">{{ $spec->value_ar }}</strong>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            {{-- طريقة الطلب --}}
                            <div class="alf-detail-tab-content" id="alfTab-ordering">
                                <div class="alf-detail-order-steps">
                                    <div>
                                        <span>01</span>
                                        <h3 data-ar="اختر المنتج" data-en="Choose the Product">اختر المنتج</h3>
                                        <p data-ar="راجع الصور والتفاصيل وحدد المنتج المناسب."
                                            data-en="Review the images and details, then choose the right product.">
                                            راجع الصور والتفاصيل وحدد المنتج المناسب.</p>
                                    </div>

                                    <div>
                                        <span>02</span>
                                        <h3 data-ar="أضف ملاحظاتك" data-en="Add Your Notes">أضف ملاحظاتك</h3>
                                        <p data-ar="اكتب المقاسات والكمية وأي تفاصيل تريدها في خانة الملاحظات."
                                            data-en="Write the dimensions, quantity, and any details in the notes box.">
                                            اكتب المقاسات والكمية وأي تفاصيل تريدها في خانة الملاحظات.</p>
                                    </div>

                                    <div>
                                        <span>03</span>
                                        <h3 data-ar="أرسل الطلب" data-en="Submit Your Order">أرسل الطلب</h3>
                                        <p data-ar="تواصل عبر واتساب لتأكيد التفاصيل والسعر النهائي."
                                            data-en="Contact us via WhatsApp to confirm the details and final price.">
                                            تواصل عبر واتساب لتأكيد التفاصيل والسعر النهائي.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ---------- معلومات المنتج ---------- --}}
                    <div class="col-lg-6">
                        <div class="alf-detail-info">

                            <div class="alf-detail-topline">
                                @if ($subCat)
                                    <a class="alf-detail-category" style="text-decoration:none"
                                        href="{{ route('products.index', ['sub_category' => $subCat->id]) }}"
                                        data-ar="{{ $catAr }}"
                                        data-en="{{ $catEn }}">{{ $catAr }}</a>
                                @endif

                                <span class="alf-detail-code">SKU: {{ $product->id }}</span>
                            </div>

                            <h2 class="alf-detail-title" data-ar="{{ $nameAr }}"
                                data-en="{{ $nameEn }}">{{ $nameAr }}</h2>

                            @if ($descAr)
                                <p class="alf-detail-short-description" data-ar="{{ $descAr }}"
                                    data-en="{{ $descEn }}">{{ $descAr }}</p>
                            @endif

                            <div class="alf-detail-price-box">
                                <div>
                                    <span class="alf-detail-price-caption" data-ar="السعر يبدأ من"
                                        data-en="Price Starts From">السعر يبدأ من</span>

                                    <div class="alf-detail-price">
                                        {{ number_format($product->price, 2) }}
                                        <small data-ar="ر.س" data-en="SAR">ر.س</small>
                                    </div>
                                </div>

                                <div class="alf-detail-price-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                            </div>

                            <div class="alf-detail-order-panel">
                                <div class="alf-detail-order-heading">
                                    <div>
                                        <span data-ar="خصص طلبك" data-en="Customize Your Order">خصص طلبك</span>
                                        <h3 data-ar="مواصفات المنتج" data-en="Product Specifications">مواصفات المنتج
                                        </h3>
                                    </div>
                                    <i class="fas fa-sliders"></i>
                                </div>

                                <label for="alfDetailNotes" class="alf-detail-notes-label">
                                    <span data-ar="ملاحظات إضافية" data-en="Additional Notes">ملاحظات إضافية</span>
                                    <span data-ar="(اختياري)" data-en="(Optional)">(اختياري)</span>
                                </label>

                                <textarea id="alfDetailNotes" rows="3" placeholder="مثال: طباعة شعار الشركة، كتابة اسم المكرّم، لون معين..."></textarea>

                                <a href="https://wa.me/966545953908" id="alfDetailWhatsapp"
                                    class="alf-detail-whatsapp" target="_blank" rel="noopener noreferrer">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <span data-ar="اطلب المنتج عبر واتساب"
                                        data-en="Order This Product via WhatsApp">اطلب المنتج عبر واتساب</span>
                                    <i class="fas fa-arrow-up-left"></i>
                                </a>

                                <div class="alf-detail-order-security">
                                    <i class="fas fa-shield-halved"></i>
                                    <span data-ar="سيتم إرسال تفاصيل طلبك مباشرة إلى فريق الفنان"
                                        data-en="Your order details will be sent directly to the Al Fannan team">
                                        سيتم إرسال تفاصيل طلبك مباشرة إلى فريق الفنان
                                    </span>
                                </div>
                            </div>

                            <div class="alf-detail-meta">
                                @if ($subCat)
                                    <div>
                                        <span data-ar="القسم" data-en="Category">القسم</span>
                                        <strong data-ar="{{ $catAr }}"
                                            data-en="{{ $catEn }}">{{ $catAr }}</strong>
                                    </div>
                                @endif

                                <div>
                                    <span data-ar="رقم المنتج" data-en="Product Number">رقم المنتج</span>
                                    <strong>{{ $product->id }}</strong>
                                </div>

                                {{-- <div>
                                    <span data-ar="منطقة الخدمة" data-en="Service Area">منطقة الخدمة</span>
                                    <strong data-ar="مكة المكرمة" data-en="Makkah">مكة المكرمة</strong>
                                </div> --}}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ===================== منتجات مشابهة ===================== --}}
        @if ($related->count())
            <section class="alf-detail-related-section">
                <div class="container">
                    <div class="alf-detail-related-heading">
                        <div>
                            <span class="alf-detail-section-eyebrow" data-ar="قد يعجبك أيضاً"
                                data-en="You May Also Like">قد يعجبك أيضاً</span>
                            <h2>
                                <span data-ar="منتجات" data-en="Related">منتجات</span>
                                <span data-ar="مشابهة" data-en="Products">مشابهة</span>
                            </h2>
                            <p data-ar="اكتشف المزيد من منتجاتنا المميزة."
                                data-en="Discover more of our featured products.">
                                اكتشف المزيد من منتجاتنا المميزة.
                            </p>
                        </div>
                        <a href="{{ route('products.index') }}">
                            <span data-ar="عرض جميع المنتجات" data-en="View All Products">عرض جميع المنتجات</span>
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>

                    <div class="row g-4" id="alfDetailRelatedProducts">
                        @foreach ($related as $item)
                            <div class="col-md-6 col-lg-3">
                                <article class="product-card">
                                    <div class="product-card-image">
                                        <a href="{{ route('products.show', $item) }}"
                                            class="product-card-image-link">
                                            <img src="{{ asset($item->image) }}" alt="{{ $item->name_ar }}"
                                                loading="lazy">
                                        </a>

                                        <a href="{{ route('products.show', $item) }}" class="product-card-quick"
                                            aria-label="تفاصيل المنتج">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>

                                    <div class="product-card-content">
                                        <div class="product-card-category"
                                            data-ar="{{ $item->subCategory->name_ar ?? '' }}"
                                            data-en="{{ $item->subCategory->name_en ?? '' ?: $item->subCategory->name_ar ?? '' }}">
                                            {{ $item->subCategory->name_ar ?? '' }}
                                        </div>

                                        <h3 class="product-card-title">
                                            <a href="{{ route('products.show', $item) }}"
                                                style="color:inherit;text-decoration:none"
                                                data-ar="{{ $item->name_ar }}"
                                                data-en="{{ $item->name_en ?: $item->name_ar }}">
                                                {{ $item->name_ar }}
                                            </a>
                                        </h3>

                                        <div class="product-card-price-row">
                                            <span class="product-card-price-label" data-ar="السعر يبدأ من"
                                                data-en="Price Starts From">السعر يبدأ من</span>
                                            <strong class="product-card-price">
                                                {{ number_format($item->price, 2) }}
                                                <span data-ar="ر.س" data-en="SAR">ر.س</span>
                                            </strong>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- ===================== CTA ===================== --}}
        <section class="alf-detail-cta-section">
            <div class="container">
                <div class="alf-detail-cta">
                    <div class="alf-detail-cta-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div>
                        <span data-ar="نحن هنا لمساعدتك" data-en="We're Here to Help">نحن هنا لمساعدتك</span>
                        <h2 data-ar="هل تحتاج إلى تصميم بمواصفات خاصة؟" data-en="Need a Custom Design?">هل تحتاج إلى
                            تصميم بمواصفات خاصة؟</h2>
                        <p data-ar="تواصل مع فريق الفنان لمناقشة فكرتك والحصول على التفاصيل المناسبة."
                            data-en="Contact the Al Fannan team to discuss your idea and get the right details.">
                            تواصل مع فريق الفنان لمناقشة فكرتك والحصول على التفاصيل المناسبة.
                        </p>
                    </div>
                    <a href="https://wa.me/966545953908" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span data-ar="تحدث معنا" data-en="Talk to Us">تحدث معنا</span>
                    </a>
                </div>
            </div>
        </section>

    </main>

    {{-- ===================== تكبير الصورة ===================== --}}
    <div class="modal fade alf-detail-lightbox" id="alfDetailLightbox" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content alf-detail-lightbox-content">
                <button type="button" data-bs-dismiss="modal" class="alf-detail-lightbox-close" aria-label="إغلاق">
                    <i class="fas fa-xmark"></i>
                </button>
                <div class="modal-body">
                    <img id="alfDetailLightboxImage" src="" alt="صورة المنتج مكبرة">
                </div>
            </div>
        </div>
    </div>

    <footer class="alf-footer" id="footer" dir="rtl">
        <div class="alf-footer-glow alf-footer-glow-one"></div>
        <div class="alf-footer-glow alf-footer-glow-two"></div>

        <div class="container">

            <div class="row g-4 alf-footer-main">

                <div class="col-lg-4 col-md-6">
                    <div class="alf-footer-about">
                        <a href="{{ url('/') }}" class="alf-footer-brand">
                            <span>
                                <img src="{{ asset('images/logo-2.png') }}" height="70" alt="Al Fannan Logo">
                                <img src="{{ asset('images/logo-3.png') }}" height="70" alt="Al Fannan Logo">
                            </span>
                        </a>

                        <p data-ar="في شركة الفنان، نجمع بين الخبرة والإبداع والجودة لنقدم حلولاً متكاملة في الدعاية والإعلان والطباعة الرقمية والهدايا الدعائية، ونساعد علامتك التجارية على التميز."
                            data-en="At Al Fannan, we combine experience, creativity, and quality to provide integrated solutions in advertising, digital printing, and promotional gifts, helping your brand stand out.">
                            في شركة الفنان، نجمع بين الخبرة والإبداع والجودة
                            لنقدم حلولاً متكاملة في الدعاية والإعلان والطباعة
                            الرقمية والهدايا الدعائية، ونساعد علامتك التجارية
                            على التميز.
                        </p>

                        <div class="alf-footer-experience">
                            <div class="alf-footer-experience-icon">
                                <i class="fa-solid fa-award"></i>
                            </div>

                            <div>
                                <strong data-ar="+18 عاماً من الخبرة" data-en="18+ Years of Experience">
                                    +18 عاماً من الخبرة
                                </strong>
                                <span data-ar="إبداع وجودة وثقة منذ البداية"
                                    data-en="Creativity, Quality, and Trust from the Start">
                                    إبداع وجودة وثقة منذ البداية
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="alf-footer-column">
                        <h3 data-ar="روابط سريعة" data-en="Quick Links">روابط سريعة</h3>

                        <ul class="alf-footer-links">
                            <li>
                                <a href="{{ url('/') }}">
                                    <i class="fa-solid fa-angle-left"></i>
                                    <span data-ar="الرئيسية" data-en="Home">الرئيسية</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('products.index') }}">
                                    <i class="fa-solid fa-angle-left"></i>
                                    <span data-ar="جميع المنتجات" data-en="All Products">جميع المنتجات</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#about">
                                    <i class="fa-solid fa-angle-left"></i>
                                    <span data-ar="من نحن" data-en="About Us">من نحن</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#why-us">
                                    <i class="fa-solid fa-angle-left"></i>
                                    <span data-ar="لماذا الفنان؟" data-en="Why Al Fannan?">لماذا الفنان؟</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#contact">
                                    <i class="fa-solid fa-angle-left"></i>
                                    <span data-ar="تواصل معنا" data-en="Contact Us">تواصل معنا</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="alf-footer-column">
                        <h3 data-ar="خدماتنا" data-en="Our Services">خدماتنا</h3>

                        <ul class="alf-footer-links">
                            @foreach ($categories->take(7) as $category)
                                <li>
                                    <a href="{{ route('products.index', ['category' => $category->id]) }}">
                                        <i class="fa-solid fa-angle-left"></i>
                                        <span data-ar="{{ $category->name_ar }}"
                                            data-en="{{ $category->name_en ?: $category->name_ar }}">{{ $category->name_ar }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="alf-footer-column">
                        <h3 data-ar="تواصل معنا" data-en="Contact Us">تواصل معنا</h3>

                        <div class="alf-footer-contact-list">

                            <a href="tel:+966545953908" class="alf-footer-contact-item">
                                <span class="alf-footer-contact-icon">
                                    <i class="fa-solid fa-phone-volume"></i>
                                </span>

                                <span>
                                    <small data-ar="اتصل بنا" data-en="Call Us">اتصل بنا</small>
                                    <strong dir="ltr">+966 54 595 3908</strong>
                                </span>
                            </a>

                            <a href="mailto:alfanaan.adv2@gmail.com" class="alf-footer-contact-item">
                                <span class="alf-footer-contact-icon">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>

                                <span>
                                    <small data-ar="البريد الإلكتروني" data-en="Email">البريد الإلكتروني</small>
                                    <strong dir="ltr">alfanaan.adv2@gmail.com</strong>
                                </span>
                            </a>

                            <div class="alf-footer-contact-item">
                                <span class="alf-footer-contact-icon">
                                    <i class="fa-solid fa-location-dot"></i>
                                </span>

                                <span>
                                    <small data-ar="موقعنا" data-en="Our Location">موقعنا</small>
                                    <strong data-ar="مكة المكرمة - الشوقية - شارع أريكة بن شريح بجوار جامع الصابرين"
                                        data-en="Makkah - Al Shawqiyyah - Areekah Bin Shuraih Street, Next to Al Sabireen Mosque">
                                        مكة المكرمة - الشوقية - شارع أريكة بن شريح
                                        بجوار جامع الصابرين
                                    </strong>
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="alf-footer-features">
                <div class="alf-footer-feature">
                    <i class="fa-solid fa-medal"></i>
                    <span data-ar="جودة في التنفيذ" data-en="Quality Workmanship">جودة في التنفيذ</span>
                </div>

                <div class="alf-footer-feature">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <span data-ar="تصاميم إبداعية" data-en="Creative Designs">تصاميم إبداعية</span>
                </div>

                <div class="alf-footer-feature">
                    <i class="fa-solid fa-handshake"></i>
                    <span data-ar="خدمة عملاء مميزة" data-en="Excellent Customer Service">خدمة عملاء مميزة</span>
                </div>

                <div class="alf-footer-feature">
                    <i class="fa-solid fa-tags"></i>
                    <span data-ar="أسعار منافسة" data-en="Competitive Prices">أسعار منافسة</span>
                </div>
            </div>

            <div class="alf-footer-bottom">
                <p>
                    <span data-ar="جميع الحقوق محفوظة ©" data-en="All Rights Reserved ©">جميع الحقوق محفوظة ©</span>
                    <span id="alfFooterYear"></span>
                    <strong data-ar="شركة الفنان للدعاية والإعلان والطباعة الرقمية"
                        data-en="Al Fannan Advertising and Digital Printing Company">
                        شركة الفنان للدعاية والإعلان والطباعة الرقمية
                    </strong>
                </p>

                <a href="#" class="alf-footer-backtop">
                    <span data-ar="العودة للأعلى" data-en="Back to Top">العودة للأعلى</span>
                    <i class="fa-solid fa-arrow-up"></i>
                </a>
            </div>

        </div>
    </footer>

    <a class="whatsapp-float" href="https://wa.me/966545953908" target="_blank" rel="noopener"
        aria-label="تواصل عبر واتساب"><i class="fa-brands fa-whatsapp"></i></a>
    <button class="back-to-top" id="backToTop" aria-label="العودة للأعلى">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.2/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.2/dist/ScrollTrigger.min.js"></script>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/language.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const product = @json($jsProduct);
            const images = @json($jsImages);
            const phone = '966545953908';
            const isEn = () => document.documentElement.lang.toLowerCase().startsWith('en');

            // ---------- المعرض ----------
            const mainImage = document.getElementById('alfDetailMainImage');
            const counter = document.getElementById('alfDetailCurrentImage');
            const thumbs = Array.from(document.querySelectorAll('.alf-detail-thumbnail'));
            let current = 0;

            function showImage(index) {
                if (!images.length) return;
                current = (index + images.length) % images.length;
                mainImage.src = images[current];
                if (counter) counter.textContent = String(current + 1).padStart(2, '0');
                thumbs.forEach((t, i) => t.classList.toggle('active', i === current));
            }

            thumbs.forEach((t, i) => t.addEventListener('click', () => showImage(i)));
            document.getElementById('alfDetailPrev')?.addEventListener('click', () => showImage(current - 1));
            document.getElementById('alfDetailNext')?.addEventListener('click', () => showImage(current + 1));

            // ---------- تكبير الصورة ----------
            document.getElementById('alfDetailZoom')?.addEventListener('click', function() {
                const modalEl = document.getElementById('alfDetailLightbox');
                if (!modalEl || typeof bootstrap === 'undefined') return;

                document.getElementById('alfDetailLightboxImage').src = images[current] || mainImage.src;
                bootstrap.Modal.getOrCreateInstance(modalEl).show();
            });

            mainImage?.addEventListener('click', () => document.getElementById('alfDetailZoom')?.click());

            // ---------- التابات ----------
            const tabButtons = document.querySelectorAll('.alf-detail-tabs button');

            tabButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    tabButtons.forEach(b => {
                        b.classList.toggle('active', b === btn);
                        b.setAttribute('aria-selected', b === btn ? 'true' : 'false');
                    });

                    document.querySelectorAll('.alf-detail-tab-content').forEach(c => {
                        c.classList.toggle('active', c.id === 'alfTab-' + btn.dataset.tab);
                    });
                });
            });

            // ---------- رابط واتساب ----------
            const notesField = document.getElementById('alfDetailNotes');
            const waButton = document.getElementById('alfDetailWhatsapp');

            function buildWhatsappLink() {
                const notes = (notesField?.value || '').trim();
                let lines;

                if (isEn()) {
                    lines = [
                        'Hello Al Fannan Advertising 👋',
                        '',
                        'I would like to order the following product:',
                        '',
                        '📦 Product: ' + product.name_en,
                        '🏷️ Product ID: ' + product.id,
                        '📂 Category: ' + product.category_en,
                        '💰 Listed Price: ' + product.price + ' SAR',
                        '🔗 Link: ' + product.url,
                    ];
                    if (notes) lines.push('', '📝 Notes: ' + notes);
                    lines.push('', 'Please confirm the final price and production time.', 'Thank you.');
                } else {
                    lines = [
                        'مرحباً شركة الفنان للدعاية والإعلان 👋',
                        '',
                        'أرغب في طلب المنتج التالي:',
                        '',
                        '📦 اسم المنتج: ' + product.name_ar,
                        '🏷️ رقم المنتج: ' + product.id,
                        '📂 القسم: ' + product.category_ar,
                        '💰 السعر المعروض: ' + product.price + ' ر.س',
                        '🔗 الرابط: ' + product.url,
                    ];
                    if (notes) lines.push('', '📝 ملاحظات: ' + notes);
                    lines.push('', 'أرجو تأكيد السعر النهائي ومدة التنفيذ.', 'شكراً لكم.');
                }

                return 'https://wa.me/' + phone + '?text=' + encodeURIComponent(lines.join('\n'));
            }

            if (waButton) {
                waButton.href = buildWhatsappLink();
                waButton.addEventListener('click', () => {
                    waButton.href = buildWhatsappLink();
                });
                notesField?.addEventListener('input', () => {
                    waButton.href = buildWhatsappLink();
                });
            }

            // placeholder الملاحظات حسب اللغة
            function updateNotesPlaceholder() {
                if (!notesField) return;
                notesField.placeholder = isEn() ?
                    "Example: Print the company logo, add the recipient's name, choose a specific color..." :
                    'مثال: طباعة شعار الشركة، كتابة اسم المكرّم، لون معين...';
            }

            updateNotesPlaceholder();
            document.addEventListener('languageChanged', () => {
                updateNotesPlaceholder();
                if (waButton) waButton.href = buildWhatsappLink();
            });
        });
    </script>
</body>

</html>

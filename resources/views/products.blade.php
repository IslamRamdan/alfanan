<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />

    <style>
        /* رابط "جميع المنتجات" بنفس شكل الأزرار القديمة */
        .products-categories .products-all-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }

        .products-sidebar-search button[type="submit"] {
            background: none;
            border: 0;
            padding: 0;
            cursor: pointer;
            color: inherit;
        }

        .products-empty a.products-reset-link {
            display: inline-block;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="alf-topbar">
        <div class="alf-topbar-container">

            <div class="alf-topbar-search">
                <i class="fas fa-search"></i>
                <input type="search" id="siteSearch" data-i18n-placeholder="topbar.searchPlaceholder"
                    data-ar="ابحث عن منتج أو خدمة..." data-en="Search for a product or service..."
                    placeholder="ابحث عن منتج أو خدمة...">
            </div>

            <div class="alf-topbar-delivery">
                <i class="fas fa-truck-fast"></i>
                <span data-i18n="topbar.deliveryMessage" data-ar="توصيل مجاني داخل مكة لأي طلب فوق"
                    data-en="Free delivery within Makkah on orders over">
                    توصيل مجاني داخل مكة لأي طلب فوق
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
                            <span data-ar="{{ $category->name_ar }}" data-en="{{ $category->name_en }}">
                                {{ $category->name_ar }}
                            </span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>

                        <div class="mega-menu">
                            <div class="mega-menu-content">
                                {{-- اسم القسم الرئيسي كرابط يعرض كل منتجاته --}}
                                <a class="mega-label"
                                    href="{{ route('products.index', ['category' => $category->id]) }}"
                                    data-ar="{{ $category->name_ar }}" data-en="{{ $category->name_en }}">
                                    {{ $category->name_ar }}
                                </a>

                                @foreach ($category->subCategories as $subCategory)
                                    <a href="{{ route('products.index', ['sub_category' => $subCategory->id]) }}">
                                        <i class="fa-solid fa-circle-dot"></i>
                                        <span data-ar="{{ $subCategory->name_ar }}"
                                            data-en="{{ $subCategory->name_en }}">
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

                <style>
                    /* القائمة الفرعية */
                    .products-category-submenu {
                        display: none;
                    }

                    .products-category-dropdown.is-open>.products-category-submenu {
                        display: block !important;
                        height: auto !important;
                        max-height: none !important;
                        opacity: 1 !important;
                        visibility: visible !important;
                        overflow: visible !important;
                    }

                    .products-category-submenu-inner {
                        display: block !important;
                        height: auto !important;
                        min-height: 0 !important;
                        overflow: visible !important;
                        padding: 8px 10px 12px;
                    }

                    .products-category-submenu a {
                        display: block !important;
                        opacity: 1 !important;
                        visibility: visible !important;
                        padding: 10px 14px;
                        margin-bottom: 4px;
                        border-radius: 10px;
                        color: #4b3a2a !important;
                        font-size: 14px;
                        text-decoration: none;
                        transition: background .2s, color .2s;
                    }

                    .products-category-submenu a:hover {
                        background: #f6f0e8;
                        color: #8b6b4a !important;
                    }

                    .products-category-submenu a.active {
                        background: #8b6b4a;
                        color: #fff !important;
                        font-weight: 700;
                    }
                </style>
            </nav>
        </div>
    </header>


    <section class="products-hero">
        <div class="container py-5">
            <div class="products-hero-content pt-5">
                <span class="products-hero-eyebrow">
                    <i class="fas fa-sparkles"></i>
                    <span data-i18n="productsHero.eyebrow" data-ar="مجموعة منتجات الفنان"
                        data-en="Al Fannan Product Collection">
                        مجموعة منتجات الفنان
                    </span>
                </span>

                <h1>
                    <span data-i18n="productsHero.titleFirst" data-ar="منتجات تصنع"
                        data-en="Products That Create">منتجات تصنع</span>
                    <span data-i18n="productsHero.titleHighlight" data-ar="التميّز"
                        data-en="Excellence">التميّز</span>
                </h1>

                <p data-i18n="productsHero.description"
                    data-ar="اكتشف مجموعتنا المتنوعة من الهدايا الدعائية والدروع التذكارية والمطبوعات المصممة بعناية لتترك انطباعاً يدوم."
                    data-en="Explore our diverse collection of promotional gifts, commemorative awards, and carefully crafted prints designed to leave a lasting impression.">
                    اكتشف مجموعتنا المتنوعة من الهدايا الدعائية والدروع التذكارية
                    والمطبوعات المصممة بعناية لتترك انطباعاً يدوم.
                </p>

                <div class="products-breadcrumb">
                    <a href="{{ url('/') }}" data-i18n="productsHero.home" data-ar="الرئيسية" data-en="Home">
                        الرئيسية
                    </a>
                    <i class="fas fa-chevron-left"></i>
                    <span data-i18n="productsHero.products" data-ar="المنتجات" data-en="Products">
                        المنتجات
                    </span>
                </div>
            </div>

            <div class="products-hero-decoration">
                <i class="fas fa-award"></i>
            </div>
        </div>
    </section>


    <main class="products-page" id="products">
        <div class="container">
            <div class="row g-4">

                {{-- ===================== السايد بار ===================== --}}
                <div class="col-lg-3">
                    <aside class="products-sidebar" id="productsSidebar">

                        <div class="products-sidebar-head">
                            <div>
                                <span data-i18n="productsPage.sidebarEyebrow" data-ar="اكتشف مجموعتنا"
                                    data-en="Explore Our Collection">اكتشف مجموعتنا</span>
                                <h2 data-i18n="productsPage.sidebarTitle" data-ar="أقسام المنتجات"
                                    data-en="Product Categories">أقسام المنتجات</h2>
                            </div>
                            <div class="products-sidebar-head-icon">
                                <i class="fas fa-layer-group"></i>
                            </div>
                        </div>

                        {{-- البحث (فورم GET) --}}
                        <form method="GET" action="{{ route('products.index') }}" class="products-sidebar-search">
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if (request('sub_category'))
                                <input type="hidden" name="sub_category" value="{{ request('sub_category') }}">
                            @endif
                            @if (request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif

                            <input type="search" name="q" id="sidebarSearch" value="{{ request('q') }}"
                                placeholder="ابحث عن منتج..." aria-label="البحث عن منتج"
                                data-i18n-placeholder="productsPage.searchPlaceholder"
                                data-i18n-aria-label="productsPage.searchLabel" data-ar="ابحث عن منتج..."
                                data-en="Search for a product...">
                            <button type="submit" aria-label="بحث">
                                <i class="fas fa-magnifying-glass"></i>
                            </button>
                        </form>

                        <div class="products-categories" id="productsCategories">

                            {{-- جميع المنتجات (رابط) --}}
                            <a href="{{ route('products.index') }}"
                                class="products-all-link {{ !request()->hasAny(['category', 'sub_category', 'q']) ? 'active' : '' }}">
                                <span>
                                    <i class="fas fa-border-all"></i>
                                    <span data-i18n="productsPage.allProducts" data-ar="جميع المنتجات"
                                        data-en="All Products">جميع المنتجات</span>
                                </span>
                                <span class="category-count"
                                    id="allCategoryCount">{{ \App\Models\Product::count() }}</span>
                            </a>

                            @foreach ($categories as $category)
                                @php
                                    $isOpen =
                                        request('category') == $category->id ||
                                        $category->subCategories->contains('id', request('sub_category'));
                                @endphp

                                <div class="products-category-dropdown {{ $isOpen ? 'is-open' : '' }}">
                                    <button class="products-category-trigger {{ $isOpen ? 'active' : '' }}"
                                        type="button" aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                                        <span>
                                            <i class="fas fa-folder"></i>
                                            <span data-ar="{{ $category->name_ar }}"
                                                data-en="{{ $category->name_en }}">
                                                {{ $category->name_ar }}
                                            </span>
                                        </span>
                                        <i class="fas fa-chevron-down category-arrow"></i>
                                    </button>

                                    <div class="products-category-submenu">

                                        {{-- كل منتجات القسم الرئيسي --}}
                                        <a href="{{ route('products.index', ['category' => $category->id]) }}"
                                            class="{{ request('category') == $category->id && !request('sub_category') ? 'active' : '' }}"
                                            data-ar="كل {{ $category->name_ar }}"
                                            data-en="All {{ $category->name_en }}">
                                            كل {{ $category->name_ar }}
                                        </a>

                                        @foreach ($category->subCategories as $subCategory)
                                            <a href="{{ route('products.index', ['sub_category' => $subCategory->id]) }}"
                                                class="{{ request('sub_category') == $subCategory->id ? 'active' : '' }}"
                                                data-ar="{{ $subCategory->name_ar }}"
                                                data-en="{{ $subCategory->name_en }}">
                                                {{ $subCategory->name_ar }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <div class="products-sidebar-help">
                            <div class="products-sidebar-help-icon">
                                <i class="fas fa-headset"></i>
                            </div>

                            <h3 data-i18n="productsPage.helpTitle" data-ar="تبحث عن تصميم خاص؟"
                                data-en="Looking for a Custom Design?">تبحث عن تصميم خاص؟</h3>

                            <p data-i18n="productsPage.helpDescription"
                                data-ar="فريق الفنان جاهز لمساعدتك في تنفيذ فكرتك بالشكل الذي يليق بعلامتك التجارية."
                                data-en="The Al Fannan team is ready to help bring your idea to life in a way that reflects your brand.">
                                فريق الفنان جاهز لمساعدتك في تنفيذ فكرتك بالشكل الذي يليق بعلامتك التجارية.
                            </p>

                            <a href="https://wa.me/966545953908" id="productsHelpWhatsapp" target="_blank"
                                rel="noopener noreferrer">
                                <span data-i18n="productsPage.contactUs" data-ar="تواصل معنا"
                                    data-en="Contact Us">تواصل معنا</span>
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>

                    </aside>
                </div>

                {{-- ===================== المحتوى الرئيسي ===================== --}}
                <div class="col-lg-9">
                    <div class="products-main">

                        <div class="products-intro">
                            <div class="products-intro-icon">
                                <i class="fas fa-gift"></i>
                            </div>

                            <div class="products-intro-content">
                                <span data-i18n="productsPage.introEyebrow" data-ar="الجودة والإبداع في كل تفصيلة"
                                    data-en="Quality and Creativity in Every Detail">
                                    الجودة والإبداع في كل تفصيلة
                                </span>

                                <h2 id="productsCategoryTitle"
                                    data-ar="{{ $currentSubCategory->name_ar ?? ($currentCategory->name_ar ?? 'جميع منتجاتنا') }}"
                                    data-en="{{ $currentSubCategory->name_en ?? ($currentCategory->name_en ?? 'All Our Products') }}">
                                    {{ $currentSubCategory->name_ar ?? ($currentCategory->name_ar ?? 'جميع منتجاتنا') }}
                                </h2>

                                <p id="productsCategoryDescription"
                                    data-ar="اختر من مجموعتنا المتنوعة من المنتجات الدعائية والدروع والهدايا والمطبوعات التي تجمع بين جودة التنفيذ وجمال التصميم."
                                    data-en="Explore our diverse collection of promotional products, awards, gifts, and printed materials, combining high-quality craftsmanship with beautiful design.">
                                    اختر من مجموعتنا المتنوعة من المنتجات الدعائية والدروع
                                    والهدايا والمطبوعات التي تجمع بين جودة التنفيذ
                                    وجمال التصميم.
                                </p>
                            </div>
                        </div>

                        <div class="products-toolbar">
                            <div class="products-results">
                                <span class="products-results-dot"></span>
                                <span data-i18n="productsPage.showing" data-ar="عرض" data-en="Showing">عرض</span>
                                <strong id="productsVisibleCount">{{ $products->total() }}</strong>
                                <span data-i18n="productsPage.productUnit" data-ar="منتج"
                                    data-en="Products">منتج</span>
                            </div>

                            <div class="products-toolbar-controls">
                                <div class="products-sort">
                                    <label for="productsSort" data-i18n="productsPage.sortLabel" data-ar="ترتيب حسب"
                                        data-en="Sort By">
                                        ترتيب حسب
                                    </label>

                                    <select id="productsSort" onchange="applySort(this.value)">
                                        <option value="" data-i18n="productsPage.sortDefault"
                                            data-ar="الترتيب الافتراضي" data-en="Default Order"
                                            {{ !request('sort') ? 'selected' : '' }}>الترتيب الافتراضي</option>
                                        <option value="price-low" data-i18n="productsPage.sortLow"
                                            data-ar="السعر: الأقل أولاً" data-en="Price: Low to High"
                                            {{ request('sort') == 'price-low' ? 'selected' : '' }}>السعر: الأقل
                                            أولاً</option>
                                        <option value="price-high" data-i18n="productsPage.sortHigh"
                                            data-ar="السعر: الأعلى أولاً" data-en="Price: High to Low"
                                            {{ request('sort') == 'price-high' ? 'selected' : '' }}>السعر: الأعلى
                                            أولاً</option>
                                        <option value="name" data-i18n="productsPage.sortName" data-ar="اسم المنتج"
                                            data-en="Product Name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                                            اسم المنتج</option>
                                    </select>
                                </div>

                                <div class="products-view-buttons">
                                    <button class="active" data-view="grid" aria-label="عرض شبكي">
                                        <i class="fas fa-border-all"></i>
                                    </button>

                                    <button data-view="list" aria-label="عرض قائمة">
                                        <i class="fas fa-list"></i>
                                    </button>
                                </div>

                                <button class="products-filter-mobile" id="productsFilterToggle">
                                    <i class="fas fa-sliders"></i>
                                    <span data-i18n="productsPage.categories" data-ar="الأقسام"
                                        data-en="Categories">الأقسام</span>
                                </button>
                            </div>
                        </div>

                        {{-- ===================== المنتجات ===================== --}}
                        @if ($products->count())
                            <div class="products-grid">
                                @foreach ($products as $product)
                                    <article class="product-card" data-product-id="{{ $product->id }}">
                                        <div class="product-card-image">
                                            <a href="{{ route('products.show', $product) }}"
                                                class="product-card-image-link">
                                                <img src="{{ asset($product->image) }}"
                                                    alt="{{ $product->name_ar }}" loading="lazy">
                                            </a>

                                            @if ($product->is_best_seller ?? false)
                                                <span class="product-card-badge" data-ar="الأكثر طلباً"
                                                    data-en="Best Seller">الأكثر طلباً</span>
                                            @endif

                                            <a href="{{ route('products.show', $product) }}"
                                                class="product-card-quick" aria-label="تفاصيل المنتج">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>

                                        <div class="product-card-content">
                                            <div class="product-card-category"
                                                data-ar="{{ $product->subCategory->name_ar ?? '' }}"
                                                data-en="{{ $product->subCategory->name_en ?? '' }}">
                                                {{ $product->subCategory->name_ar ?? '' }}
                                            </div>

                                            <h3 class="product-card-title">
                                                <a href="{{ route('products.show', $product) }}"
                                                    style="color:inherit;text-decoration:none"
                                                    data-ar="{{ $product->name_ar }}"
                                                    data-en="{{ $product->name_en }}">
                                                    {{ $product->name_ar }}
                                                </a>
                                            </h3>

                                            <p class="product-card-description"
                                                data-ar="{{ $product->description_ar }}"
                                                data-en="{{ $product->description_en }}">
                                                {{ $product->description_ar }}
                                            </p>

                                            <div class="product-card-price-row">
                                                <span class="product-card-price-label" data-ar="السعر يبدأ من"
                                                    data-en="Price Starts From">السعر يبدأ من</span>
                                                <strong class="product-card-price">
                                                    {{ number_format($product->price, 2) }}
                                                    <span data-ar="ر.س" data-en="SAR">ر.س</span>
                                                </strong>
                                            </div>

                                            @php
                                                $whatsappMsg = urlencode('أرغب في طلب ' . $product->name_ar);
                                            @endphp
                                            <a class="product-card-whatsapp"
                                                href="https://wa.me/966545953908?text={{ $whatsappMsg }}"
                                                target="_blank" rel="noopener noreferrer">
                                                <i class="fa-brands fa-whatsapp"></i>
                                                <span data-ar="اطلب عبر واتساب" data-en="Order via WhatsApp">اطلب
                                                    عبر واتساب</span>
                                                <i class="fas fa-arrow-up-left"></i>
                                            </a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="products-empty" id="productsEmpty">
                                <i class="fas fa-box-open"></i>

                                <h3 data-i18n="productsPage.emptyTitle" data-ar="لا توجد منتجات مطابقة"
                                    data-en="No Matching Products">لا توجد منتجات مطابقة</h3>

                                <p data-i18n="productsPage.emptyDescription"
                                    data-ar="جرب البحث بكلمة أخرى أو اختر قسماً مختلفاً."
                                    data-en="Try searching with another keyword or choose a different category.">
                                    جرب البحث بكلمة أخرى أو اختر قسماً مختلفاً.
                                </p>

                                <a href="{{ route('products.index') }}" id="productsReset"
                                    class="products-reset-link" data-i18n="productsPage.resetButton"
                                    data-ar="عرض جميع المنتجات" data-en="Show All Products">
                                    عرض جميع المنتجات
                                </a>
                            </div>
                        @endif

                        {{-- ===================== الباجينيشن ===================== --}}
                        <div class="products-pagination" id="productsPagination">
                            {{ $products->links() }}
                        </div>

                        <div class="products-bottom-cta">
                            <div class="products-bottom-cta-icon">
                                <i class="fas fa-comments"></i>
                            </div>

                            <div>
                                <span data-i18n="productsPage.ctaEyebrow" data-ar="هل لديك فكرة مختلفة؟"
                                    data-en="Have a Different Idea?">
                                    هل لديك فكرة مختلفة؟
                                </span>

                                <h3 data-i18n="productsPage.ctaTitle" data-ar="نحوّل أفكارك إلى منتجات إبداعية مميزة"
                                    data-en="We Turn Your Ideas into Unique Creative Products">
                                    نحوّل أفكارك إلى منتجات إبداعية مميزة
                                </h3>

                                <p data-i18n="productsPage.ctaDescription"
                                    data-ar="تواصل معنا لمناقشة متطلباتك والحصول على عرض سعر مناسب."
                                    data-en="Contact us to discuss your requirements and receive a suitable quotation.">
                                    تواصل معنا لمناقشة متطلباتك والحصول على عرض سعر مناسب.
                                </p>
                            </div>

                            <a href="https://wa.me/966545953908" id="productsQuoteWhatsapp" target="_blank"
                                rel="noopener noreferrer">
                                <span data-i18n="productsPage.ctaButton" data-ar="اطلب عرض سعر"
                                    data-en="Request a Quote">اطلب عرض سعر</span>
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>


    @php
        // يدعم سواء بعتّه كسجل واحد ($siteLink) أو كـ Collection ($siteLinks)
        $linksRecord = $siteLink ?? ($siteLinks ?? null);
        if ($linksRecord instanceof \Illuminate\Support\Collection) {
            $linksRecord = $linksRecord->first();
        }

        $socialPlatforms = [
            'facebook' => ['icon' => 'fa-brands fa-facebook-f', 'label' => 'Facebook'],
            'instagram' => ['icon' => 'fa-brands fa-instagram', 'label' => 'Instagram'],
            'tiktok' => ['icon' => 'fa-brands fa-tiktok', 'label' => 'TikTok'],
            'snapchat' => ['icon' => 'fa-brands fa-snapchat', 'label' => 'Snapchat'],
            'x' => ['icon' => 'fa-brands fa-x-twitter', 'label' => 'X'],
            'whatsapp' => ['icon' => 'fa-brands fa-whatsapp', 'label' => 'WhatsApp'],
            'youtube' => ['icon' => 'fa-brands fa-youtube', 'label' => 'YouTube'],
            'linkedin' => ['icon' => 'fa-brands fa-linkedin-in', 'label' => 'LinkedIn'],
        ];

        $hasAnySocial = false;
        if ($linksRecord) {
            foreach ($socialPlatforms as $field => $meta) {
                if (!empty($linksRecord->$field)) {
                    $hasAnySocial = true;
                    break;
                }
            }
        }
    @endphp

    <style>
        .alf-footer-socials {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            margin-top: 18px;
        }

        .alf-footer-social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(212, 175, 55, 0.35);
            color: #f5d061;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .alf-footer-social-btn:hover {
            background: #d4af37;
            border-color: #d4af37;
            color: #111111;
            transform: translateY(-3px);
        }
    </style>

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

                        <p data-i18n="footer.description"
                            data-ar="في شركة الفنان، نجمع بين الخبرة والإبداع والجودة لنقدم حلولاً متكاملة في الدعاية والإعلان والطباعة الرقمية والهدايا الدعائية، ونساعد علامتك التجارية على التميز."
                            data-en="At Al Fannan, we combine experience, creativity, and quality to provide integrated advertising, digital printing, and promotional gift solutions that help your brand stand out.">
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
                                <strong data-i18n="footer.experienceTitle" data-ar="+18 عاماً من الخبرة"
                                    data-en="18+ Years of Experience">
                                    +18 عاماً من الخبرة
                                </strong>
                                <span data-i18n="footer.experienceText" data-ar="إبداع وجودة وثقة منذ البداية"
                                    data-en="Creativity, Quality & Trust from the Start">
                                    إبداع وجودة وثقة منذ البداية
                                </span>
                            </div>
                        </div>

                        @if ($hasAnySocial)
                            <div class="alf-footer-socials">
                                @foreach ($socialPlatforms as $field => $meta)
                                    @if (!empty($linksRecord->$field))
                                        <a href="{{ $linksRecord->$field }}" target="_blank"
                                            rel="noopener noreferrer" class="alf-footer-social-btn"
                                            aria-label="{{ $meta['label'] }}" title="{{ $meta['label'] }}">
                                            <i class="{{ $meta['icon'] }}"></i>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="alf-footer-column">
                        <h3 data-i18n="footer.quickLinksTitle" data-ar="روابط سريعة" data-en="Quick Links">روابط
                            سريعة</h3>

                        <ul class="alf-footer-links">
                            <li>
                                <a href="{{ url('/') }}">
                                    <i class="fa-solid fa-angle-left"></i>
                                    <span data-i18n="footer.home" data-ar="الرئيسية" data-en="Home">الرئيسية</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('products.index') }}">
                                    <i class="fa-solid fa-angle-left"></i>
                                    <span data-i18n="footer.allProducts" data-ar="جميع المنتجات"
                                        data-en="All Products">جميع المنتجات</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#services">
                                    <i class="fa-solid fa-angle-left"></i>
                                    <span data-i18n="footer.services" data-ar="خدماتنا"
                                        data-en="Our Services">خدماتنا</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#about">
                                    <i class="fa-solid fa-angle-left"></i>
                                    <span data-i18n="footer.about" data-ar="من نحن" data-en="About Us">من
                                        نحن</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#why-us">
                                    <i class="fa-solid fa-angle-left"></i>
                                    <span data-i18n="footer.whyUs" data-ar="لماذا الفنان؟"
                                        data-en="Why Al Fannan?">لماذا الفنان؟</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#contact">
                                    <i class="fa-solid fa-angle-left"></i>
                                    <span data-i18n="footer.contact" data-ar="تواصل معنا" data-en="Contact Us">تواصل
                                        معنا</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="alf-footer-column">
                        <h3 data-i18n="footer.servicesTitle" data-ar="خدماتنا" data-en="Our Services">خدماتنا</h3>

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
                        <h3 data-i18n="footer.contactTitle" data-ar="تواصل معنا" data-en="Contact Us">تواصل معنا
                        </h3>

                        <div class="alf-footer-contact-list">

                            <a href="tel:+966545953908" class="alf-footer-contact-item">
                                <span class="alf-footer-contact-icon">
                                    <i class="fa-solid fa-phone-volume"></i>
                                </span>

                                <span>
                                    <small data-i18n="footer.callUs" data-ar="اتصل بنا" data-en="Call Us">اتصل
                                        بنا</small>
                                    <strong dir="ltr">+966 54 595 3908</strong>
                                </span>
                            </a>

                            <a href="mailto:alfanaan.adv2@gmail.com" class="alf-footer-contact-item">
                                <span class="alf-footer-contact-icon">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>

                                <span>
                                    <small data-i18n="footer.email" data-ar="البريد الإلكتروني"
                                        data-en="Email Address">البريد الإلكتروني</small>
                                    <strong dir="ltr">alfanaan.adv2@gmail.com</strong>
                                </span>
                            </a>

                            <div class="alf-footer-contact-item">
                                <span class="alf-footer-contact-icon">
                                    <i class="fa-solid fa-location-dot"></i>
                                </span>

                                <span>
                                    <small data-i18n="footer.location" data-ar="موقعنا"
                                        data-en="Our Location">موقعنا</small>
                                    <strong data-i18n="footer.address"
                                        data-ar="مكة المكرمة - الشوقية - شارع أريكة بن شريح بجوار جامع الصابرين"
                                        data-en="Makkah - Al Shawqiyyah - Areekah bin Shuraih Street, next to Al Sabireen Mosque">
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
                    <span data-i18n="footer.featureQuality" data-ar="جودة في التنفيذ"
                        data-en="Quality Execution">جودة في التنفيذ</span>
                </div>

                <div class="alf-footer-feature">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <span data-i18n="footer.featureCreative" data-ar="تصاميم إبداعية"
                        data-en="Creative Designs">تصاميم إبداعية</span>
                </div>

                <div class="alf-footer-feature">
                    <i class="fa-solid fa-handshake"></i>
                    <span data-i18n="footer.featureSupport" data-ar="خدمة عملاء مميزة"
                        data-en="Excellent Customer Service">خدمة عملاء مميزة</span>
                </div>

                <div class="alf-footer-feature">
                    <i class="fa-solid fa-tags"></i>
                    <span data-i18n="footer.featurePrices" data-ar="أسعار منافسة" data-en="Competitive Prices">أسعار
                        منافسة</span>
                </div>
            </div>

            <div class="alf-footer-bottom">
                <p>
                    <span data-i18n="footer.copyright" data-ar="جميع الحقوق محفوظة ©"
                        data-en="All Rights Reserved ©">جميع الحقوق محفوظة ©</span>
                    <span id="alfFooterYear"></span>
                    <strong data-i18n="footer.companyName" data-ar="شركة الفنان للدعاية والإعلان والطباعة الرقمية"
                        data-en="Al Fannan Advertising & Digital Printing Company">
                        شركة الفنان للدعاية والإعلان والطباعة الرقمية
                    </strong>
                </p>

                <a href="#home" class="alf-footer-backtop">
                    <span data-i18n="footer.backToTop" data-ar="العودة للأعلى" data-en="Back to Top">العودة
                        للأعلى</span>
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
        // الترتيب: بيضيف/يشيل sort من الرابط ويحافظ على باقي الفلاتر
        function applySort(value) {
            const url = new URL(window.location.href);
            value ? url.searchParams.set('sort', value) : url.searchParams.delete('sort');
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }

        // فتح/قفل القوائم الفرعية في السايد بار
        document.querySelectorAll('.products-category-trigger').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const submenu = btn.nextElementSibling;
                const open = submenu.style.display === 'block';
                submenu.style.display = open ? 'none' : 'block';
                btn.setAttribute('aria-expanded', open ? 'false' : 'true');
            });
        });
    </script>
</body>

</html>

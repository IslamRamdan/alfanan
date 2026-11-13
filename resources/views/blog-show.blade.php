<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $blog->meta_title_ar ?: $blog->title_ar }} | شركة الفنان للدعاية والإعلان والطباعة الرقمية</title>

    @php
        $metaDescription =
            $blog->meta_description_ar ?: \Illuminate\Support\Str::limit(strip_tags($blog->description_ar), 160);
    @endphp
    <meta name="description" content="{{ $metaDescription }}">
    @if ($blog->meta_keywords_ar)
        <meta name="keywords" content="{{ $blog->meta_keywords_ar }}">
    @endif

    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $blog->meta_title_ar ?: $blog->title_ar }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ asset($blog->image) }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />

    <style>
        /* ===== صفحة تفاصيل المدونة (ألوان محايدة تشتغل مع الوضع الفاتح والداكن) ===== */
        .alf-blog-show {
            padding: 150px 0 90px;
        }

        .alf-blog-article {
            max-width: 820px;
            margin: 0 auto;
        }

        .alf-blog-back {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
            text-decoration: none;
            color: inherit;
            opacity: .8;
        }

        .alf-blog-back:hover {
            opacity: 1;
            color: inherit;
        }

        .alf-blog-show-title {
            font-weight: 800;
            line-height: 1.6;
            margin: 0 0 .75rem;
        }

        .alf-blog-show-meta {
            font-size: .9rem;
            opacity: .65;
            margin-bottom: 1.75rem;
        }

        .alf-blog-show-meta i {
            margin-inline-end: .35rem;
        }

        .alf-blog-show-image {
            border-radius: 1rem;
            overflow: hidden;
            margin-bottom: 2rem;
            background: rgba(128, 128, 128, .12);
        }

        .alf-blog-show-image img {
            display: block;
            width: 100%;
            max-height: 480px;
            object-fit: cover;
        }

        .alf-blog-content {
            font-size: 1.05rem;
            line-height: 2.1;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        .alf-blog-share {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: .75rem;
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(128, 128, 128, .25);
        }

        .alf-blog-share-label {
            font-weight: 700;
        }

        .alf-blog-share a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1px solid rgba(128, 128, 128, .35);
            color: inherit;
            text-decoration: none;
            transition: border-color .2s, transform .2s;
        }

        .alf-blog-share a:hover {
            border-color: currentColor;
            transform: translateY(-2px);
            color: inherit;
        }

        /* مقالات أخرى */
        .alf-blog-related {
            margin-top: 5rem;
        }

        .alf-blog-related h2 {
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .alf-blog-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid rgba(128, 128, 128, .25);
            border-radius: 1rem;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            background: transparent;
            transition: border-color .2s, transform .2s;
        }

        .alf-blog-card:hover {
            border-color: currentColor;
            transform: translateY(-4px);
            color: inherit;
        }

        .alf-blog-card-image {
            aspect-ratio: 16 / 10;
            overflow: hidden;
            background: rgba(128, 128, 128, .12);
        }

        .alf-blog-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .alf-blog-card-body {
            padding: 1.1rem 1.25rem 1.3rem;
        }

        .alf-blog-card-title {
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.6;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @media (max-width: 991.98px) {
            .alf-blog-show {
                padding-top: 120px;
            }
        }
    </style>
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
                                {{-- اسم القسم الرئيسي كرابط يعرض كل منتجاته --}}
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

                <a href="{{ route('blogs.index') }}" class="nav-link active">
                    <span data-ar="المدونة" data-en="Blog">المدونة</span>
                </a>
                <a href="{{ route('marketing') }}" class="nav-link">
                    <span data-ar="التسويق والبرمجة" data-en="Marketing & Programming">التسويق والبرمجة</span>
                </a>


            </nav>
        </div>
    </header>

    <main>

        <section class="alf-blog-show" id="blog" dir="rtl">
            <div class="container">

                <article class="alf-blog-article" data-aos="fade-up">

                    <a href="{{ route('blogs.index') }}" class="alf-blog-back">
                        <i class="fa-solid fa-arrow-right"></i>
                        <span data-ar="العودة إلى المدونة" data-en="Back to Blog">العودة إلى المدونة</span>
                    </a>

                    <h1 class="alf-blog-show-title" data-ar="{{ $blog->title_ar }}"
                        data-en="{{ $blog->title_en ?: $blog->title_ar }}">
                        {{ $blog->title_ar }}
                    </h1>

                    @if ($blog->created_at)
                        <div class="alf-blog-show-meta">
                            <i class="fa-regular fa-calendar"></i>
                            {{ $blog->created_at->format('Y/m/d') }}
                        </div>
                    @endif

                    <div class="alf-blog-show-image">
                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title_ar }}">
                    </div>

                    <div class="alf-blog-content" data-ar="{{ $blog->description_ar }}"
                        data-en="{{ $blog->description_en ?: $blog->description_ar }}">{{ $blog->description_ar }}
                    </div>

                    <div class="alf-blog-share">
                        <span class="alf-blog-share-label" data-ar="شارك المقال" data-en="Share this article">شارك
                            المقال</span>

                        <a href="https://wa.me/?text={{ urlencode($blog->title_ar . ' ' . url()->current()) }}"
                            target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>

                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                            target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title_ar) }}"
                            target="_blank" rel="noopener noreferrer" aria-label="X">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                    </div>

                </article>

                {{-- مقالات أخرى: مرّر $relatedBlogs من الكنترولر (اختياري) --}}
                @if (isset($relatedBlogs) && $relatedBlogs->count())
                    <div class="alf-blog-related" data-aos="fade-up">
                        <h2 data-ar="مقالات أخرى" data-en="More Articles">مقالات أخرى</h2>

                        <div class="row g-4">
                            @foreach ($relatedBlogs as $related)
                                <div class="col-lg-4 col-md-6">
                                    <a href="{{ route('blogs.show', $related->id) }}" class="alf-blog-card">
                                        <div class="alf-blog-card-image">
                                            <img src="{{ asset($related->image) }}" alt="{{ $related->title_ar }}"
                                                loading="lazy">
                                        </div>
                                        <div class="alf-blog-card-body">
                                            <h3 class="alf-blog-card-title" data-ar="{{ $related->title_ar }}"
                                                data-en="{{ $related->title_en ?: $related->title_ar }}">
                                                {{ $related->title_ar }}
                                            </h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </section>

    </main>


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
                                <a href="{{ route('blogs.index') }}">
                                    <i class="fa-solid fa-angle-left"></i>
                                    <span data-ar="المدونة" data-en="Blog">المدونة</span>
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

                <a href="#blog" class="alf-footer-backtop">
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
</body>

</html>

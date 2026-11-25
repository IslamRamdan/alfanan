<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>المدونة | شركة الفنان للدعاية والإعلان والطباعة الرقمية</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />

    <style>
        /* ===== صفحة المدونات (ألوان محايدة تشتغل مع الوضع الفاتح والداكن) ===== */
        .alf-blogs-page {
            padding: 150px 0 90px;
        }

        .alf-blogs-heading {
            max-width: 720px;
            margin: 0 auto 3rem;
            text-align: center;
        }

        .alf-blogs-heading h1 {
            font-weight: 800;
            line-height: 1.5;
            margin: .75rem 0;
        }

        .alf-blogs-heading p {
            opacity: .8;
            line-height: 2;
            margin: 0;
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
            transition: transform .4s;
        }

        .alf-blog-card:hover .alf-blog-card-image img {
            transform: scale(1.05);
        }

        .alf-blog-card-body {
            display: flex;
            flex-direction: column;
            gap: .6rem;
            padding: 1.25rem 1.25rem 1.4rem;
            flex: 1;
        }

        .alf-blog-card-date {
            font-size: .8rem;
            opacity: .65;
        }

        .alf-blog-card-date i {
            margin-inline-end: .35rem;
        }

        .alf-blog-card-title {
            font-size: 1.15rem;
            font-weight: 700;
            line-height: 1.6;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .alf-blog-card-text {
            font-size: .95rem;
            line-height: 1.9;
            opacity: .8;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .alf-blog-card-more {
            margin-top: auto;
            padding-top: .5rem;
            font-weight: 700;
            font-size: .95rem;
        }

        .alf-blog-card-more i {
            margin-inline-start: .35rem;
            transition: transform .2s;
        }

        .alf-blog-card:hover .alf-blog-card-more i {
            transform: translateX(-4px);
        }

        .alf-blogs-empty {
            text-align: center;
            padding: 4rem 1rem;
            border: 1px dashed rgba(128, 128, 128, .4);
            border-radius: 1rem;
        }

        .alf-blogs-empty i {
            font-size: 2.5rem;
            opacity: .5;
            margin-bottom: 1rem;
        }

        .alf-blogs-pagination {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        @media (max-width: 991.98px) {
            .alf-blogs-page {
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

        <section class="alf-blogs-page" id="blogs" dir="rtl">
            <div class="container">

                <div class="alf-blogs-heading" data-aos="fade-up">
                    <span class="alf-services-eyebrow">
                        <i class="fa-solid fa-newspaper"></i>
                        <span data-ar="المدونة" data-en="Blog">المدونة</span>
                    </span>

                    <h1>
                        <span class="about-highlight" data-ar="أحدث مقالاتنا" data-en="Our Latest Articles">أحدث
                            مقالاتنا</span>
                    </h1>
                </div>

                @if ($blogs->count())
                    <div class="row g-4">
                        @foreach ($blogs as $blog)
                            <div class="col-lg-4 col-md-6" data-aos="fade-up"
                                data-aos-delay="{{ ($loop->index % 3) * 50 }}">

                                <a href="{{ route('blogs.show', $blog) }}" class="alf-blog-card">

                                    <div class="alf-blog-card-image">
                                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title_ar }}"
                                            loading="lazy">
                                    </div>

                                    <div class="alf-blog-card-body">
                                        @if ($blog->created_at)
                                            <span class="alf-blog-card-date">
                                                <i class="fa-regular fa-calendar"></i>
                                                {{ $blog->created_at->format('Y/m/d') }}
                                            </span>
                                        @endif

                                        <h2 class="alf-blog-card-title" data-ar="{{ $blog->title_ar }}"
                                            data-en="{{ $blog->title_en ?: $blog->title_ar }}">
                                            {{ $blog->title_ar }}
                                        </h2>

                                        <p class="alf-blog-card-text"
                                            data-ar="{{ \Illuminate\Support\Str::limit(strip_tags($blog->description_ar), 140) }}"
                                            data-en="{{ \Illuminate\Support\Str::limit(strip_tags($blog->description_en ?: $blog->description_ar), 140) }}">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($blog->description_ar), 140) }}
                                        </p>

                                        <span class="alf-blog-card-more">
                                            <span data-ar="اقرأ المزيد" data-en="Read More">اقرأ المزيد</span>
                                            <i class="fa-solid fa-arrow-left"></i>
                                        </span>
                                    </div>

                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alf-blogs-empty" data-aos="fade-up">
                        <i class="fa-regular fa-folder-open"></i>
                        <p class="mb-0" data-ar="لا توجد مدونات حالياً" data-en="No blog posts available yet">لا
                            توجد
                            مدونات حالياً</p>
                    </div>
                @endif

            </div>
        </section>

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
</body>

</html>

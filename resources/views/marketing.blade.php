<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>التسويق والبرمجة | شركة الفنان للدعاية والإعلان والطباعة الرقمية</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
    <style>
        .alf-whatsapp-direct-btn {
            /* انسخ هنا نفس تنسيق الكلاس القديم .alf-package-btn */
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            background-color: #25d366;
            /* لون واتساب مثلاً أو اللون المعتمد لديك */
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .alf-whatsapp-direct-btn:hover {
            opacity: 0.9;
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
                <span>🇸🇦</span><span>العربية</span><i class="fa-solid fa-check"></i>
            </button>
            <button type="button" class="language-option" data-lang="en">
                <span>🇺🇸</span><span>English</span><i class="fa-solid fa-check"></i>
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
                <span></span><span></span><span></span>
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

                <a href="{{ route('marketing') }}" class="nav-link active">
                    <span data-ar="التسويق والبرمجة" data-en="Marketing & Programming">التسويق والبرمجة</span>
                </a>

            </nav>
        </div>
    </header>

    <main>

        @php
            $wa = 'https://wa.me/966545953908';

            // رسالة واتساب جاهزة باسم الخدمة
            $waMsg = fn(string $service) => $wa .
                '?text=' .
                rawurlencode('السلام عليكم، أرغب في الاستفسار عن خدمة: ' . $service);

            $siteFeatures = [
                [
                    'fa-mobile-screen-button',
                    'تصميم متجاوب',
                    'Responsive Design',
                    'يظهر موقعك بشكل مثالي على الجوال والتابلت والكمبيوتر.',
                    'Your site looks perfect on mobile, tablet, and desktop.',
                ],
                [
                    'fa-language',
                    'عربي وإنجليزي',
                    'Arabic & English',
                    'دعم كامل للغتين مع اتجاه RTL وLTR لتصل لكل عملائك.',
                    'Full support for both languages with RTL and LTR layouts.',
                ],
                [
                    'fa-bolt',
                    'سرعة في التحميل',
                    'Fast Loading',
                    'صفحات خفيفة وسريعة تحسّن تجربة الزائر وترتيبك في جوجل.',
                    'Lightweight, fast pages that improve visitor experience and Google ranking.',
                ],
                [
                    'fa-magnifying-glass-chart',
                    'جاهز لمحركات البحث',
                    'SEO Ready',
                    'هيكلة صحيحة للعناوين والوصف لتسهيل ظهورك في نتائج البحث.',
                    'Proper headings and meta structure to help you appear in search results.',
                ],
                [
                    'fa-whatsapp fa-brands',
                    'تواصل مباشر',
                    'Direct Contact',
                    'زر واتساب ونموذج تواصل وخريطة موقعك لتصلك الطلبات بسهولة.',
                    'WhatsApp button, contact form, and map so inquiries reach you easily.',
                ],
                [
                    'fa-shield-halved',
                    'أمان وحماية',
                    'Secure & Reliable',
                    'شهادة SSL وإعدادات أمان أساسية لحماية موقعك وزواره.',
                    'SSL certificate and core security settings to protect your site and visitors.',
                ],
            ];

            $adsFeatures = [
                [
                    'fa-bullseye',
                    'الوصول لمن يبحث عنك',
                    'Reach People Searching for You',
                    'يظهر إعلانك للعميل في اللحظة التي يبحث فيها عن خدمتك.',
                    'Your ad appears the moment a customer searches for your service.',
                ],
                [
                    'fa-location-crosshairs',
                    'استهداف دقيق',
                    'Precise Targeting',
                    'حدّد المدينة والفئة والكلمات المفتاحية ليصل إعلانك للعميل المناسب.',
                    'Choose city, audience, and keywords so your ad reaches the right customer.',
                ],
                [
                    'fa-hand-holding-dollar',
                    'ادفع مقابل النتائج',
                    'Pay for Results',
                    'التكلفة بحسب النقرات الفعلية، وبميزانية تحددها أنت.',
                    'You pay per actual click, within a budget you control.',
                ],
                [
                    'fa-chart-line',
                    'نتائج قابلة للقياس',
                    'Measurable Results',
                    'تتبّع الزيارات والمكالمات والطلبات، وتقرير شهري بالأداء.',
                    'Track visits, calls, and orders, with a monthly performance report.',
                ],
                [
                    'fa-rocket',
                    'نتائج سريعة',
                    'Fast Results',
                    'تبدأ الحملة بجلب الزيارات بعد اعتمادها مباشرة.',
                    'Your campaign starts bringing traffic soon after approval.',
                ],
                [
                    'fa-sliders',
                    'تحكم ومرونة',
                    'Flexible Control',
                    'نعدّل الحملة ونحسّنها باستمرار حسب الأداء دون التزام طويل.',
                    'We adjust and optimize continuously based on performance, with no long commitment.',
                ],
            ];

            $seoFeatures = [
                [
                    'fa-box-archive',
                    'أرشفة الموقع في جوجل',
                    'Google Indexing',
                    'نضيف موقعك إلى Google Search Console ونرسل خريطة الموقع ليبدأ جوجل بأرشفة صفحاتك.',
                    'We add your site to Google Search Console and submit a sitemap so Google starts indexing your pages.',
                ],
                [
                    'fa-key',
                    'تحليل الكلمات المفتاحية',
                    'Keyword Research',
                    'نختار الكلمات التي يبحث بها عملاؤك فعلًا ونبني عليها محتوى صفحاتك.',
                    'We pick the words your customers actually search for and build your page content around them.',
                ],
                [
                    'fa-file-lines',
                    'تحسين الصفحات',
                    'On-Page Optimization',
                    'تحسين العناوين والوصف والمحتوى والصور لكل صفحة لتتوافق مع معايير البحث.',
                    'Optimized titles, descriptions, content, and images on every page to match search standards.',
                ],
                [
                    'fa-gauge-high',
                    'إصلاح الأخطاء والسرعة',
                    'Technical Fixes & Speed',
                    'نكتشف أخطاء الأرشفة والروابط المكسورة ونحسّن سرعة التحميل.',
                    'We find indexing errors and broken links and improve loading speed.',
                ],
                [
                    'fa-infinity',
                    'زيارات مجانية مستمرة',
                    'Lasting Free Traffic',
                    'نتائج البحث الطبيعية تستمر في جلب الزوار دون دفع مقابل كل نقرة.',
                    'Organic results keep bringing visitors without paying per click.',
                ],
                [
                    'fa-chart-column',
                    'تقرير شهري',
                    'Monthly Report',
                    'تقرير واضح بترتيب كلماتك وعدد الزيارات وما تم تحسينه.',
                    'A clear report on your keyword rankings, visits, and what was improved.',
                ],
            ];
        @endphp

        <style>
            .alf-mp-hero {
                position: relative;
                padding: 150px 0 90px;
                text-align: center;
                color: #fff;
                background:
                    linear-gradient(rgba(10, 10, 10, .82), rgba(10, 10, 10, .9)),
                    url('{{ asset('images/7.jpg') }}') center / cover no-repeat;
            }

            .alf-mp-hero h1 {
                font-weight: 800;
                font-size: clamp(2rem, 5vw, 3.4rem);
                margin: 18px 0 14px;
            }

            .alf-mp-hero p {
                max-width: 640px;
                margin: 0 auto 28px;
                opacity: .9;
                line-height: 1.9;
            }

            .alf-mp-hero .hero-actions {
                display: flex;
                gap: 12px;
                justify-content: center;
                flex-wrap: wrap;
            }

            .alf-mp-period {
                font-size: .85rem;
                opacity: .8;
                margin-inline-start: 6px;
            }

            .alf-mp-pricing-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 420px));
                justify-content: center;
                gap: 28px;
            }
        </style>

        {{-- ========== Hero ========== --}}
        <section class="alf-mp-hero" id="marketing-hero">
            <div class="container">
                <span class="eyebrow hero-eyebrow justify-content-center">
                    <span class="first-span"></span>
                    <span data-ar="التسويق والبرمجة" data-en="Marketing & Programming">التسويق والبرمجة</span>
                </span>

                <h1>
                    <span class="first-span-hero" data-ar="موقعك وإعلانك" data-en="Your Website & Your Ads">موقعك
                        وإعلانك</span>
                    <span data-ar="في مكان واحد" data-en="In One Place">في مكان واحد</span>
                </h1>

                <p data-ar="نصمم لك موقعًا تعريفيًا احترافيًا، وندير حملاتك الإعلانية على جوجل، ونحسّن ظهورك في نتائج البحث لتصل إلى عملائك وتحوّل الزيارات إلى طلبات."
                    data-en="We build you a professional company website and manage your Google Ads campaigns, and improve your search ranking to reach your customers and turn visits into orders.">
                    نصمم لك موقعًا تعريفيًا احترافيًا، وندير حملاتك الإعلانية على جوجل، ونحسّن ظهورك في نتائج البحث لتصل
                    إلى عملائك وتحوّل الزيارات إلى طلبات.
                </p>

                <div class="hero-actions">
                    <a href="#mp-pricing" class="btn-gold">
                        <span data-ar="شاهد الأسعار" data-en="View Pricing">شاهد الأسعار</span>
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <a href="{{ $wa }}" target="_blank" rel="noopener noreferrer"
                        class="btn-outline-gold">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span data-ar="تواصل معنا" data-en="Contact Us">تواصل معنا</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ========== Pricing ========== --}}
        <section class="alf-pricing" id="mp-pricing">
            <div class="alf-pricing-container">

                <div class="alf-pricing-heading" data-aos="fade-up">
                    <span class="alf-pricing-eyebrow">
                        <i class="fas fa-laptop-code"></i>
                        <span data-ar="خدماتنا الرقمية" data-en="Our Digital Services">خدماتنا الرقمية</span>
                    </span>

                    <h2 data-ar="اختر الخدمة المناسبة لنشاطك" data-en="Choose the Service That Fits Your Business">
                        اختر الخدمة المناسبة لنشاطك
                    </h2>

                    <p data-ar="أسعار واضحة وثابتة، بدون رسوم مخفية."
                        data-en="Clear, fixed prices with no hidden fees.">
                        أسعار واضحة وثابتة، بدون رسوم مخفية.
                    </p>

                    <div class="alf-pricing-divider">
                        <span></span><i class="fas fa-star"></i><span></span>
                    </div>
                </div>

                <div class="alf-mp-pricing-grid">

                    {{-- Website --}}
                    <article class="alf-package-card alf-package-featured" data-aos="fade-up" data-aos-delay="100">
                        <div class="alf-package-icon"><i class="fas fa-globe"></i></div>

                        <span class="alf-package-badge">
                            <i class="fas fa-crown"></i>
                            <span data-ar="الأكثر طلبًا" data-en="Most Popular">الأكثر طلبًا</span>
                        </span>

                        <div class="alf-package-content">
                            <h3 data-ar="موقع إلكتروني تعريفي" data-en="Company Website">موقع إلكتروني تعريفي</h3>

                            <p class="alf-package-description"
                                data-ar="موقع احترافي يعرّف بشركتك وخدماتك ويسهّل على عملائك التواصل معك."
                                data-en="A professional website that presents your company and services and makes it easy for customers to reach you.">
                                موقع احترافي يعرّف بشركتك وخدماتك ويسهّل على عملائك التواصل معك.
                            </p>

                            <div class="alf-package-price">
                                <span class="alf-price-currency" data-ar="ر.س" data-en="SAR">ر.س</span>
                                <strong>850</strong>
                                <span class="alf-mp-period" data-ar="دفعة واحدة" data-en="one-time">دفعة واحدة</span>
                            </div>

                            <div class="alf-package-separator"></div>

                            <ul class="alf-package-features">
                                <li><i class="fas fa-check"></i><span data-ar="تصميم احترافي بهوية نشاطك"
                                        data-en="Professional design in your brand identity">تصميم احترافي بهوية
                                        نشاطك</span></li>
                                <li><i class="fas fa-check"></i><span data-ar="متجاوب مع جميع الأجهزة"
                                        data-en="Fully responsive on all devices">متجاوب مع جميع الأجهزة</span></li>
                                <li><i class="fas fa-check"></i><span data-ar="عربي وإنجليزي"
                                        data-en="Arabic & English">عربي وإنجليزي</span></li>
                                <li><i class="fas fa-check"></i><span data-ar="نموذج تواصل وزر واتساب"
                                        data-en="Contact form & WhatsApp button">نموذج تواصل وزر واتساب</span></li>
                                <li><i class="fas fa-check"></i><span data-ar="جاهز لمحركات البحث (SEO)"
                                        data-en="Search-engine ready (SEO)">جاهز لمحركات البحث (SEO)</span></li>
                            </ul>

                            <a href="https://wa.me/966545953908?text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D8%B9%D9%84%D9%8A%D9%83%D9%85%D8%8C%20%D8%A3%D8%B1%D8%BA%D8%A8%20%D9%81%D9%8A%20%D8%A7%D9%84%D8%A7%D8%B3%D8%AA%D9%81%D8%B3%D8%A7%D8%B1%20%D8%B9%D9%86%20%D8%AE%D8%AF%D9%85%D8%A9%3A%20%D9%85%D9%88%D9%82%D8%B9%20%D8%A5%D9%84%D9%83%D8%AA%D8%B1%D9%88%D9%86%D9%8A%20%D8%AA%D8%B9%D8%B1%D9%8A%D9%81%D9%8A%20(850%20%D8%B1%D9%8A%D8%A7%D9%84)"
                                class="alf-whatsapp-direct-btn" data-package="website" data-price="850"
                                target="_blank" rel="noopener noreferrer">
                                <span data-ar="اطلب موقعك عبر واتساب" data-en="Order via WhatsApp">اطلب موقعك عبر
                                    واتساب</span>
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </article>

                    {{-- Google Ads --}}
                    <article class="alf-package-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="alf-package-icon"><i class="fab fa-google"></i></div>

                        <span class="alf-package-badge" data-ar="اشتراك شهري" data-en="Monthly Plan">اشتراك
                            شهري</span>

                        <div class="alf-package-content">
                            <h3 data-ar="إدارة حملات جوجل الإعلانية" data-en="Google Ads Management">إدارة حملات جوجل
                                الإعلانية</h3>

                            <p class="alf-package-description"
                                data-ar="نُعدّ حملتك وندير إعلاناتك ونحسّن نتائجها شهريًا لتصل لأكبر عدد من العملاء المهتمين."
                                data-en="We set up your campaign, run your ads, and optimize results monthly to reach the most interested customers.">
                                نُعدّ حملتك وندير إعلاناتك ونحسّن نتائجها شهريًا لتصل لأكبر عدد من العملاء المهتمين.
                            </p>

                            <div class="alf-package-price">
                                <span class="alf-price-currency" data-ar="ر.س" data-en="SAR">ر.س</span>
                                <strong>500</strong>
                                <span class="alf-mp-period" data-ar="شهريًا" data-en="/ month">شهريًا</span>
                            </div>

                            <div class="alf-package-separator"></div>

                            <ul class="alf-package-features">
                                <li><i class="fas fa-check"></i><span data-ar="إعداد وإطلاق الحملة"
                                        data-en="Campaign setup & launch">إعداد وإطلاق الحملة</span></li>
                                <li><i class="fas fa-check"></i><span data-ar="اختيار الكلمات المفتاحية والاستهداف"
                                        data-en="Keyword research & targeting">اختيار الكلمات المفتاحية
                                        والاستهداف</span></li>
                                <li><i class="fas fa-check"></i><span data-ar="كتابة نصوص الإعلانات"
                                        data-en="Ad copywriting">كتابة نصوص الإعلانات</span></li>
                                <li><i class="fas fa-check"></i><span data-ar="متابعة وتحسين مستمر"
                                        data-en="Ongoing monitoring & optimization">متابعة وتحسين مستمر</span></li>
                                <li><i class="fas fa-check"></i><span data-ar="تقرير أداء شهري"
                                        data-en="Monthly performance report">تقرير أداء شهري</span></li>
                            </ul>

                            <a href="https://wa.me/966545953908?text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D8%B9%D9%84%D9%8A%D9%83%D9%85%D8%8C%20%D8%A3%D8%B1%D8%BA%D8%A8%20%D9%81%D9%8A%20%D8%A7%D9%84%D8%A7%D8%B3%D8%AA%D9%81%D8%B3%D8%A7%D8%B1%20%D8%B9%D9%86%20%D8%AE%D8%AF%D9%85%D8%A9%3A%20%D8%A5%D8%AF%D8%A7%D8%B1%D8%A9%20%D8%AD%D9%85%D9%84%D8%A7%D8%AA%20%D8%AC%D9%88%D8%AC%D9%84%20%D8%A7%D9%84%D8%A5%D8%B9%D9%84%D8%A7%D9%86%D9%8A%D8%A9%20(500%20%D8%B1%D9%8A%D8%A7%D9%84%20%D8%B4%D9%87%D8%B1%D9%8A%D9%8B%D8%A7)"
                                class="alf-whatsapp-direct-btn" data-package="google-ads" data-price="500"
                                target="_blank" rel="noopener noreferrer">
                                <span data-ar="ابدأ حملتك عبر واتساب" data-en="Start via WhatsApp">ابدأ حملتك عبر
                                    واتساب</span>
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </article>

                    {{-- SEO --}}
                    <article class="alf-package-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="alf-package-icon"><i class="fas fa-magnifying-glass-chart"></i></div>

                        <span class="alf-package-badge" data-ar="اشتراك شهري" data-en="Monthly Plan">اشتراك
                            شهري</span>

                        <div class="alf-package-content">
                            <h3 data-ar="الأرشفة وتحسين محركات البحث (SEO)" data-en="Indexing & SEO">الأرشفة وتحسين
                                محركات البحث (SEO)</h3>

                            <p class="alf-package-description"
                                data-ar="نؤرشف موقعك في جوجل ونحسّن ظهوره في نتائج البحث الطبيعية بشكل تدريجي ومستمر."
                                data-en="We index your site on Google and steadily improve its visibility in organic search results.">
                                نؤرشف موقعك في جوجل ونحسّن ظهوره في نتائج البحث الطبيعية بشكل تدريجي ومستمر.
                            </p>

                            <div class="alf-package-price">
                                <span class="alf-price-currency" data-ar="ر.س" data-en="SAR">ر.س</span>
                                <strong>500</strong>
                                <span class="alf-mp-period" data-ar="شهريًا" data-en="/ month">شهريًا</span>
                            </div>

                            <div class="alf-package-separator"></div>

                            <ul class="alf-package-features">
                                <li><i class="fas fa-check"></i><span data-ar="أرشفة الموقع في جوجل"
                                        data-en="Google indexing">أرشفة الموقع في جوجل</span></li>
                                <li><i class="fas fa-check"></i><span data-ar="تحليل الكلمات المفتاحية"
                                        data-en="Keyword research">تحليل الكلمات المفتاحية</span></li>
                                <li><i class="fas fa-check"></i><span data-ar="تحسين الصفحات والمحتوى"
                                        data-en="Page & content optimization">تحسين الصفحات والمحتوى</span></li>
                                <li><i class="fas fa-check"></i><span data-ar="إصلاح الأخطاء التقنية والسرعة"
                                        data-en="Technical fixes & speed">إصلاح الأخطاء التقنية والسرعة</span></li>
                                <li><i class="fas fa-check"></i><span data-ar="تقرير أداء شهري"
                                        data-en="Monthly performance report">تقرير أداء شهري</span></li>
                            </ul>

                            <a href="https://wa.me/966545953908?text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D8%B9%D9%84%D9%8A%D9%83%D9%85%D8%8C%20%D8%A3%D8%B1%D8%BA%D8%A8%20%D9%81%D9%8A%20%D8%A7%D9%84%D8%A7%D8%B3%D8%AA%D9%81%D8%B3%D8%A7%D8%B1%20%D8%B9%D9%86%20%D8%AE%D8%AF%D9%85%D8%A9%3A%20%D8%A7%D9%84%D8%A3%D8%B1%D8%B4%D9%81%D8%A9%20%D9%88%D8%AA%D8%AD%D8%B3%D9%8A%D9%86%20%D9%85%D8%AD%D8%B1%D9%83%D8%A7%D8%AA%20%D8%A7%D9%84%D8%A8%D8%AD%D8%AB%20SEO%20(500%20%D8%B1%D9%8A%D8%A7%D9%84%20%D8%B4%D9%87%D8%B1%D9%8A%D9%8B%D8%A7)"
                                class="alf-whatsapp-direct-btn" data-package="seo" data-price="500" target="_blank"
                                rel="noopener noreferrer">
                                <span data-ar="ابدأ الأرشفة عبر واتساب" data-en="Start via WhatsApp">ابدأ الأرشفة عبر
                                    واتساب</span>
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </article>

                </div>

                <p class="text-center mt-4" style="opacity:.75" data-aos="fade-up"
                    data-ar="ميزانية الإعلانات التي تُدفع لجوجل مستقلة عن رسوم الإدارة."
                    data-en="The ad budget paid to Google is separate from the management fee.">
                    ميزانية الإعلانات التي تُدفع لجوجل مستقلة عن رسوم الإدارة.
                </p>
            </div>
        </section>

        {{-- ========== Website features (dark section) ========== --}}
        <section class="alf-why-section" id="website-features" dir="rtl">
            <div class="alf-why-bg"></div>
            <div class="alf-why-overlay"></div>
            <div class="alf-why-noise"></div>

            <div class="container alf-why-container">
                <div class="alf-why-heading" data-aos="fade-up">
                    <div class="alf-why-eyebrow">
                        <span class="alf-why-eyebrow-line"></span>
                        <span class="alf-why-eyebrow-text">
                            <i class="fa-solid fa-laptop-code"></i>
                            <span data-ar="مميزات مواقعنا" data-en="Our Website Features">مميزات مواقعنا</span>
                        </span>
                        <span class="alf-why-eyebrow-line"></span>
                    </div>

                    <h2>
                        <span data-ar="موقع يعمل لصالحك" data-en="A Website That Works for You">موقع يعمل
                            لصالحك</span>
                        <span data-ar="على مدار الساعة" data-en="Around the Clock">على مدار الساعة</span>
                    </h2>

                    <p data-ar="نبني مواقع سريعة وواضحة تعكس هوية نشاطك وتحوّل الزائر إلى عميل."
                        data-en="We build fast, clear websites that reflect your brand and turn visitors into customers.">
                        نبني مواقع سريعة وواضحة تعكس هوية نشاطك وتحوّل الزائر إلى عميل.
                    </p>
                </div>

                <div class="row g-4 alf-why-grid">
                    @foreach ($siteFeatures as $i => $f)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 50 + $i * 50 }}">
                            <article class="alf-why-card">
                                <div class="alf-why-icon"><i class="fa-solid {{ $f[0] }}"></i></div>
                                <h3 data-ar="{{ $f[1] }}" data-en="{{ $f[2] }}">{{ $f[1] }}
                                </h3>
                                <p data-ar="{{ $f[3] }}" data-en="{{ $f[4] }}">{{ $f[3] }}
                                </p>
                                <span class="alf-why-card-line"></span>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ========== Google Ads features ========== --}}
        <section class="alf-services-section" id="ads-features" dir="rtl">
            <div class="container">

                <div class="alf-services-heading">
                    <div class="alf-services-heading-content">
                        <span class="alf-services-eyebrow">
                            <i class="fa-brands fa-google"></i>
                            <span data-ar="مميزات إعلانات جوجل" data-en="Google Ads Benefits">مميزات إعلانات
                                جوجل</span>
                        </span>

                        <h2>
                            <span class="about-highlight" data-ar="إعلانات تصل" data-en="Ads That Reach">إعلانات
                                تصل</span>
                            <span data-ar="للعميل في الوقت المناسب" data-en="the Customer at the Right Time">للعميل في
                                الوقت المناسب</span>
                        </h2>

                        <p data-ar="جوجل هو أول مكان يبحث فيه العميل. نضمن لك الظهور أمامه بميزانية تتحكم بها."
                            data-en="Google is the first place customers search. We make sure you appear in front of them, on a budget you control.">
                            جوجل هو أول مكان يبحث فيه العميل. نضمن لك الظهور أمامه بميزانية تتحكم بها.
                        </p>
                    </div>

                    <a href="{{ $wa }}" target="_blank" rel="noopener noreferrer"
                        class="alf-services-all-btn">
                        <span data-ar="اطلب استشارة" data-en="Request a Consultation">اطلب استشارة</span>
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                </div>

                <div class="row g-4">
                    @foreach ($adsFeatures as $i => $f)
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ 50 + $i * 50 }}">
                            <div class="alf-service-card">
                                <div class="alf-service-icon"><i class="fa-solid {{ $f[0] }}"></i></div>

                                <div class="alf-service-content">
                                    <h3 data-ar="{{ $f[1] }}" data-en="{{ $f[2] }}">
                                        {{ $f[1] }}</h3>
                                    <p data-ar="{{ $f[3] }}" data-en="{{ $f[4] }}">
                                        {{ $f[3] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="alf-services-footer">
                    <span>
                        <i class="fa-solid fa-circle-check"></i>
                        <span data-ar="موقع + إعلانات = عملاء أكثر" data-en="Website + Ads = More Customers">موقع +
                            إعلانات = عملاء أكثر</span>
                    </span>

                    <a href="{{ $wa }}" target="_blank" rel="noopener noreferrer">
                        <span data-ar="ابدأ مشروعك الآن" data-en="Start Your Project Now">ابدأ مشروعك الآن</span>
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </section>


        {{-- ========== SEO features ========== --}}
        <section class="alf-why-section" id="seo-features" dir="rtl">
            <div class="alf-why-bg"></div>
            <div class="alf-why-overlay"></div>
            <div class="alf-why-noise"></div>

            <div class="container alf-why-container">
                <div class="alf-why-heading" data-aos="fade-up">
                    <div class="alf-why-eyebrow">
                        <span class="alf-why-eyebrow-line"></span>
                        <span class="alf-why-eyebrow-text">
                            <i class="fa-solid fa-magnifying-glass-chart"></i>
                            <span data-ar="مميزات الأرشفة والـ SEO" data-en="Indexing & SEO Benefits">مميزات الأرشفة
                                والـ SEO</span>
                        </span>
                        <span class="alf-why-eyebrow-line"></span>
                    </div>

                    <h2>
                        <span data-ar="اجعل عملاءك" data-en="Let Your Customers">اجعل عملاءك</span>
                        <span data-ar="يجدونك في جوجل" data-en="Find You on Google">يجدونك في جوجل</span>
                    </h2>

                    <p data-ar="الأرشفة وتحسين محركات البحث تبني ظهور موقعك تدريجيًا، والنتائج تظهر خلال أسابيع إلى أشهر حسب المنافسة."
                        data-en="Indexing and SEO build your site's visibility step by step, with results appearing over weeks to months depending on competition.">
                        الأرشفة وتحسين محركات البحث تبني ظهور موقعك تدريجيًا، والنتائج تظهر خلال أسابيع إلى أشهر حسب
                        المنافسة.
                    </p>
                </div>

                <div class="row g-4 alf-why-grid">
                    @foreach ($seoFeatures as $i => $f)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 50 + $i * 50 }}">
                            <article class="alf-why-card">
                                <div class="alf-why-icon"><i class="fa-solid {{ $f[0] }}"></i></div>
                                <h3 data-ar="{{ $f[1] }}" data-en="{{ $f[2] }}">{{ $f[1] }}
                                </h3>
                                <p data-ar="{{ $f[3] }}" data-en="{{ $f[4] }}">{{ $f[3] }}
                                </p>
                                <span class="alf-why-card-line"></span>
                            </article>
                        </div>
                    @endforeach
                </div>
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

                        <p data-ar="في شركة الفنان، نجمع بين الخبرة والإبداع والجودة لنقدم حلولاً متكاملة في الدعاية والإعلان والطباعة الرقمية والهدايا الدعائية، ونساعد علامتك التجارية على التميز."
                            data-en="At Al Fannan, we combine experience, creativity, and quality to provide integrated advertising, digital printing, and promotional gift solutions that help your brand stand out.">
                            في شركة الفنان، نجمع بين الخبرة والإبداع والجودة
                            لنقدم حلولاً متكاملة في الدعاية والإعلان والطباعة
                            الرقمية والهدايا الدعائية، ونساعد علامتك التجارية
                            على التميز.
                        </p>

                        <div class="alf-footer-experience">
                            <div class="alf-footer-experience-icon"><i class="fa-solid fa-award"></i></div>
                            <div>
                                <strong data-ar="+18 عاماً من الخبرة" data-en="18+ Years of Experience">+18 عاماً من
                                    الخبرة</strong>
                                <span data-ar="إبداع وجودة وثقة منذ البداية"
                                    data-en="Creativity, Quality & Trust from the Start">إبداع وجودة وثقة منذ
                                    البداية</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="alf-footer-column">
                        <h3 data-ar="روابط سريعة" data-en="Quick Links">روابط سريعة</h3>
                        <ul class="alf-footer-links">
                            <li><a href="{{ url('/') }}"><i class="fa-solid fa-angle-left"></i><span
                                        data-ar="الرئيسية" data-en="Home">الرئيسية</span></a></li>
                            <li><a href="{{ route('products.index') }}"><i class="fa-solid fa-angle-left"></i><span
                                        data-ar="جميع المنتجات" data-en="All Products">جميع المنتجات</span></a></li>
                            <li><a href="{{ route('marketing') }}"><i class="fa-solid fa-angle-left"></i><span
                                        data-ar="التسويق والبرمجة" data-en="Marketing & Programming">التسويق
                                        والبرمجة</span></a></li>
                            <li><a href="{{ url('/') }}#services"><i class="fa-solid fa-angle-left"></i><span
                                        data-ar="خدماتنا" data-en="Our Services">خدماتنا</span></a></li>
                            <li><a href="{{ url('/') }}#about"><i class="fa-solid fa-angle-left"></i><span
                                        data-ar="من نحن" data-en="About Us">من نحن</span></a></li>
                            <li><a href="{{ url('/') }}#contact"><i class="fa-solid fa-angle-left"></i><span
                                        data-ar="تواصل معنا" data-en="Contact Us">تواصل معنا</span></a></li>
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
                                <span class="alf-footer-contact-icon"><i class="fa-solid fa-phone-volume"></i></span>
                                <span>
                                    <small data-ar="اتصل بنا" data-en="Call Us">اتصل بنا</small>
                                    <strong dir="ltr">+966 54 595 3908</strong>
                                </span>
                            </a>

                            <a href="mailto:alfanaan.adv2@gmail.com" class="alf-footer-contact-item">
                                <span class="alf-footer-contact-icon"><i class="fa-solid fa-envelope"></i></span>
                                <span>
                                    <small data-ar="البريد الإلكتروني" data-en="Email Address">البريد
                                        الإلكتروني</small>
                                    <strong dir="ltr">alfanaan.adv2@gmail.com</strong>
                                </span>
                            </a>

                            <div class="alf-footer-contact-item">
                                <span class="alf-footer-contact-icon"><i class="fa-solid fa-location-dot"></i></span>
                                <span>
                                    <small data-ar="موقعنا" data-en="Our Location">موقعنا</small>
                                    <strong data-ar="مكة المكرمة - الشوقية - شارع أبرهة بن شرحبيل بجوار جامع المهاجرين"
                                        data-en="Makkah - Al Shawqiyyah - Abrahah bin Shurahbil Street, next to Al Muhajireen Mosque">
                                        مكة المكرمة - الشوقية - شارع أبرهة بن شرحبيل
                                        بجوار جامع المهاجرين
                                    </strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="alf-footer-bottom">
                <p>
                    <span data-ar="جميع الحقوق محفوظة ©" data-en="All Rights Reserved ©">جميع الحقوق محفوظة ©</span>
                    <span id="alfFooterYear"></span>
                    <strong data-ar="شركة الفنان للدعاية والإعلان والطباعة الرقمية"
                        data-en="Al Fannan Advertising & Digital Printing Company">
                        شركة الفنان للدعاية والإعلان والطباعة الرقمية
                    </strong>
                </p>

                <a href="#marketing-hero" class="alf-footer-backtop">
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
</body>

</html>

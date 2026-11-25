@php
    // IDs أول 4 أقسام رئيسية (لكروت الخدمات)
    $catIds = $categories->pluck('id')->values();

    $reviews = [
        [
            'n' => 1,
            'avatar' => 'ع',
            'ar' =>
                'تجربة رائعة في التعامل وجودة الطباعة ممتازة، والتصميم والتنفيذ كانا على مستوى التوقعات. شكراً لكم على الاحترافية.',
            'en' =>
                'A wonderful experience. The printing quality was excellent, and both the design and execution exceeded our expectations. Thank you for your professionalism.',
        ],
        [
            'n' => 2,
            'avatar' => 'م',
            'ar' =>
                'تعامل راقٍ وسرعة في الإنجاز واهتمام بأدق التفاصيل. المنتجات وصلت بجودة ممتازة، وسعدنا بالتعامل معكم.',
            'en' =>
                'Excellent service, fast delivery, and great attention to detail. The products arrived in outstanding quality, and we were delighted to work with you.',
        ],
        [
            'n' => 3,
            'avatar' => 'أ',
            'ar' =>
                'جودة عالية في تنفيذ اللوحات الإعلانية، مع دقة في المقاسات واهتمام بالتفاصيل. بالتأكيد لنا تعاملات أخرى معكم.',
            'en' =>
                'High-quality advertising signs, precise measurements, and excellent attention to detail. We will certainly work with you again.',
        ],
    ];
@endphp
<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>شركة الفنان للدعاية والإعلان والطباعة الرقمية</title>

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

                <a href="{{ route('blogs.index') }}" class="nav-link">
                    <span data-ar="المدونة" data-en="Blog">المدونة</span>
                </a>

                <a href="{{ route('marketing') }}" class="nav-link">
                    <span data-ar="التسويق والبرمجة" data-en="Marketing & Programming">التسويق والبرمجة</span>
                </a>

            </nav>
        </div>
    </header>

    <main>

        <section class="hero" id="home" aria-label="مقدمة الشركة" data-i18n-aria-label="hero.ariaLabel">

            {{-- 1. صور الخلفية للسلايدر --}}
            <div class="hero-slides">
                @forelse($slides as $index => $slide)
                    <div class="hero-slide {{ $index === 0 ? 'active' : '' }}"
                        style="--hero-image: url('{{ asset('storage/' . $slide->image) }}');">
                    </div>
                @empty
                    <div class="hero-slide active" style="--hero-image: url('{{ asset('images/7.jpg') }}');"></div>
                    <div class="hero-slide" style="--hero-image: url('{{ asset('images/8.jpg') }}');"></div>
                @endforelse
            </div>

            <div class="hero-overlay"></div>
            <div class="hero-ornament hero-ornament-one"></div>
            <div class="hero-ornament hero-ornament-two"></div>

            {{-- 2. محتوى الهيرو الأساسي كما كان في الأول --}}
            <div class="container hero-container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-xl-8">
                        <div class="hero-content">

                            <div class="img mb-4">
                                <img src="{{ asset('images/logo-3.png') }}" height="100" alt="شركة الفنان">
                            </div>

                            <span class="eyebrow hero-eyebrow">
                                <span class="first-span"></span>
                                <span data-ar="شركة للدعاية والإعلان والطباعة الرقمية"
                                    data-en="Advertising, Marketing & Digital Printing Company">
                                    شركة للدعاية والإعلان والطباعة الرقمية
                                </span>
                            </span>

                            <h1 class="hero-title">
                                <span class="first-span-hero" data-ar="إبداع" data-en="Creativity">إبداع</span>
                                <span data-ar="يحقق رؤيتك" data-en="That Brings Your Vision to Life">يحقق رؤيتك</span>
                            </h1>

                            <p class="hero-description"
                                data-ar="نتميز بفريق متخصص على أعلى مستوى وبخبرة تزيد عن 18 عاماً بمكة المكرمة، ونقدم حلولاً إبداعية في تصميم الهوية البصرية والطباعة واللوحات الإعلانية والتسويق."
                                data-en="With a highly skilled team and over 18 years of experience in Makkah, we deliver creative solutions in visual identity design, printing, advertising signage, and marketing.">
                                نتميز بفريق متخصص على أعلى مستوى وبخبرة تزيد
                                عن 18 عاماً بمكة المكرمة، ونقدم حلولاً إبداعية
                                في تصميم الهوية البصرية والطباعة واللوحات
                                الإعلانية والتسويق.
                            </p>

                            <div class="hero-actions">

                                <a href="#services" class="btn-gold">
                                    <span data-ar="تعرّف على خدماتنا" data-en="Explore Our Services">
                                        تعرّف على خدماتنا
                                    </span>
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>

                                <a href="https://wa.me/966545953908" target="_blank" rel="noopener noreferrer"
                                    class="btn-outline-gold">
                                    <i class="fa-solid fa-phone"></i>
                                    <span data-ar="تواصل معنا" data-en="Contact Us">
                                        تواصل معنا
                                    </span>
                                </a>

                                <a href="{{ $siteLink?->company_profile_pdf ? asset('storage/' . $siteLink->company_profile_pdf) : '#' }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="btn-outline-gold btn-profile-download">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                    <span data-ar="تحميل بروفايل الشركة" data-en="Download Company Profile">
                                        تحميل بروفايل الشركة
                                    </span>
                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. أزرار التحكم والعداد --}}
            <div class="hero-bottom container-fluid">
                <div class="slider-controls">

                    <button class="slider-arrow" id="prevSlide" aria-label="الشريحة السابقة"
                        data-i18n-aria-label="hero.previousSlide">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <span class="slide-number">
                        <b id="currentSlide">01</b>
                        <span>/</span>
                        <span>{{ str_pad($slides->count() > 0 ? $slides->count() : 2, 2, '0', STR_PAD_LEFT) }}</span>
                    </span>

                    <div class="slide-progress">
                        <span id="slideProgress"></span>
                    </div>

                    <button class="slider-arrow" id="nextSlide" aria-label="الشريحة التالية"
                        data-i18n-aria-label="hero.nextSlide">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                </div>

                <a class="scroll-cue" href="#about">
                    <span class="scroll-mouse"><i></i></span>
                    <span data-i18n="hero.scroll">Scroll</span>
                </a>
            </div>

            {{-- 4. نقاط السلايدر السفلية --}}
            <div class="hero-dots" aria-label="اختيار الشريحة" data-i18n-aria-label="hero.selectSlide">
                @forelse($slides as $index => $slide)
                    <button class="hero-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"
                        aria-label="الشريحة {{ $index + 1 }}">
                    </button>
                @empty
                    <button class="hero-dot active" data-slide="0" aria-label="الشريحة الأولى"></button>
                    <button class="hero-dot" data-slide="1" aria-label="الشريحة الثانية"></button>
                @endforelse
            </div>

        </section>


        <section class="alf-about-section" id="about" dir="rtl">
            <div class="container-fluid alf-about-container">
                <div class="row align-items-center g-0">

                    <div class="col-lg-6 alf-about-content-col">
                        <div class="alf-about-content">

                            <div data-aos="fade-up">
                                <img src="{{ asset('images/logo-3.png') }}" height="100" alt="Al Fannan">
                            </div>

                            <div class="alf-about-eyebrow" data-aos="fade-up">
                                <span data-i18n="about.eyebrow" data-ar="من نحن" data-en="About Us">من نحن</span>
                                <span class="alf-about-eyebrow-line"></span>
                            </div>

                            <h2 class="alf-about-title" data-aos="fade-up" data-aos-delay="100">
                                <span data-i18n="about.titleFirst" data-ar="شركة الفنان للدعاية والإعلان"
                                    data-en="Al Fannan Advertising Company">
                                    شركة الفنان للدعاية والإعلان
                                </span>
                                <span class="about-highlight" data-i18n="about.titleHighlight"
                                    data-ar="والطباعة الرقمية" data-en="& Digital Printing">
                                    والطباعة الرقمية
                                </span>
                            </h2>

                            <div class="alf-about-description" data-aos="fade-up" data-aos-delay="150">

                                <p data-i18n="about.descriptionOne"
                                    data-ar="تتميز شركة الفنان للدعاية والإعلان والطباعة الرقمية بتقديم خدمات متكاملة في مجال الدعاية والإعلان والطباعة الرقمية وتصميم وتنفيذ اللوحات الإعلانية وطباعة الهدايا التذكارية، مع الحرص الدائم على تقديم كل ما هو جديد ومميز في هذا المجال."
                                    data-en="Al Fannan Advertising and Digital Printing Company provides integrated advertising, digital printing, and signage design and production services, as well as customized gift printing, always striving to deliver innovative and distinctive solutions.">
                                    تتميز شركة الفنان للدعاية والإعلان والطباعة الرقمية
                                    بتقديم خدمات متكاملة في مجال الدعاية والإعلان والطباعة
                                    الرقمية وتصميم وتنفيذ اللوحات الإعلانية وطباعة الهدايا
                                    التذكارية، مع الحرص الدائم على تقديم كل ما هو جديد
                                    ومميز في هذا المجال.
                                </p>

                                <p>
                                    <span data-i18n="about.descriptionTwoStart" data-ar="بخبرة تزيد عن"
                                        data-en="With over">
                                        بخبرة تزيد عن
                                    </span>
                                    <strong data-i18n="about.experienceYears" data-ar="18 عاماً" data-en="18 Years">
                                        18 عاماً
                                    </strong>
                                    <span data-i18n="about.descriptionTwoEnd"
                                        data-ar="في مكة المكرمة، نعمل على تقديم حلول إبداعية تلبي احتياجات عملائنا، بدءاً من تصميم الهوية البصرية والطباعة الداخلية والخارجية، مروراً بالبنرات والاستيكرات واللوحات المضيئة والكلادينج، وصولاً إلى الدروع التذكارية والهدايا وقص الليزر وتركيب استيكرات الجدران والسيارات."
                                        data-en="of experience in Makkah, we deliver creative solutions tailored to our clients' needs. Our services range from visual identity design and indoor and outdoor printing to banners, stickers, illuminated signs, cladding, commemorative awards, gifts, laser cutting, and wall and vehicle sticker installation.">
                                        في مكة المكرمة، نعمل على تقديم حلول إبداعية تلبي
                                        احتياجات عملائنا، بدءاً من تصميم الهوية البصرية
                                        والطباعة الداخلية والخارجية، مروراً بالبنرات
                                        والاستيكرات واللوحات المضيئة والكلادينج، وصولاً
                                        إلى الدروع التذكارية والهدايا وقص الليزر وتركيب
                                        استيكرات الجدران والسيارات.
                                    </span>
                                </p>

                            </div>

                            <div class="alf-about-features" data-aos="fade-up" data-aos-delay="200">

                                <div class="alf-about-feature">
                                    <div class="alf-about-feature-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h3 data-i18n="about.featureTeamTitle" data-ar="فريق متخصص"
                                        data-en="Expert Team">
                                        فريق متخصص
                                    </h3>
                                    <p data-i18n="about.featureTeamText" data-ar="على أعلى مستوى"
                                        data-en="Highly Skilled Professionals">
                                        على أعلى مستوى
                                    </p>
                                </div>

                                <div class="alf-about-feature">
                                    <div class="alf-about-feature-icon">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    <h3 data-i18n="about.featureExperienceTitle" data-ar="خبرة تزيد عن"
                                        data-en="Over">
                                        خبرة تزيد عن
                                    </h3>
                                    <p class="alf-about-feature-highlight" data-i18n="about.experienceYears"
                                        data-ar="18 عاماً" data-en="18 Years">
                                        18 عاماً
                                    </p>
                                </div>

                                <div class="alf-about-feature">
                                    <div class="alf-about-feature-icon">
                                        <i class="fas fa-location-dot"></i>
                                    </div>
                                    <h3 data-i18n="about.featureLocationTitle" data-ar="مكة المكرمة"
                                        data-en="Makkah">
                                        مكة المكرمة
                                    </h3>
                                    <p data-i18n="about.featureLocationText" data-ar="نخدم أعمالكم باحتراف"
                                        data-en="Serving Your Business Professionally">
                                        نخدم أعمالكم باحتراف
                                    </p>
                                </div>

                                <div class="alf-about-feature">
                                    <div class="alf-about-feature-icon">
                                        <i class="far fa-gem"></i>
                                    </div>
                                    <h3 data-i18n="about.featureQualityTitle" data-ar="جودة عالية"
                                        data-en="High Quality">
                                        جودة عالية
                                    </h3>
                                    <p data-i18n="about.featureQualityText" data-ar="في كل التفاصيل"
                                        data-en="In Every Detail">
                                        في كل التفاصيل
                                    </p>
                                </div>

                            </div>

                            <div class="alf-about-promise" data-aos="fade-up" data-aos-delay="250">

                                <div class="alf-about-promise-content">
                                    <span data-i18n="about.promiseEyebrow" data-ar="كن مطمئناً دوماً"
                                        data-en="Always Rest Assured">
                                        كن مطمئناً دوماً
                                    </span>
                                    <h3 data-i18n="about.promiseTitle" data-ar="نهتم بالتفاصيل لنقدم لكم الأفضل"
                                        data-en="We Care About Every Detail to Deliver the Best">
                                        نهتم بالتفاصيل لنقدم لكم الأفضل
                                    </h3>
                                </div>

                                <div class="alf-about-promise-divider"></div>

                                <div class="alf-about-promise-icon">
                                    <i class="fas fa-shield-halved"></i>
                                </div>

                                <div class="alf-about-promise-decoration"></div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6 alf-about-image-col">
                        <div class="alf-about-visual" data-aos="fade-right" data-aos-duration="1100">

                            <div class="alf-about-visual-bg"></div>
                            <div class="alf-about-visual-outline"></div>

                            <div class="alf-about-image-wrapper">
                                <img src="{{ asset('images/about.png') }}"
                                    alt="شركة الفنان للدعاية والإعلان والطباعة الرقمية" data-i18n-alt="about.imageAlt"
                                    data-ar="شركة الفنان للدعاية والإعلان والطباعة الرقمية"
                                    data-en="Al Fannan Advertising and Digital Printing Company" loading="lazy">
                            </div>

                            <div class="alf-about-experience">
                                <strong>18+</strong>
                                <span data-i18n="about.experienceLabel" data-ar="عاماً من الخبرة"
                                    data-en="Years of Experience">
                                    عاماً من الخبرة
                                </span>
                                <small data-i18n="about.experienceLocation" data-ar="في مكة المكرمة"
                                    data-en="In Makkah">
                                    في مكة المكرمة
                                </small>
                            </div>

                            <div class="alf-about-visual-dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>


        <section class="alf-vm-section" id="vision" dir="rtl">
            <div class="alf-vm-layout">
                <div class="alf-vm-visual">
                    <div class="alf-vm-visual-image"></div>
                </div>

                <div class="alf-vm-content">
                    <div class="alf-vm-heading">
                        <div class="alf-vm-eyebrow">
                            <span></span>
                            <strong data-i18n="vision.eyebrow" data-ar="رؤيتنا ورسالتنا"
                                data-en="Our Vision & Mission">رؤيتنا ورسالتنا</strong>
                            <span></span>
                        </div>

                        <h2>
                            <span class="about-highlight" data-i18n="vision.titleFirst" data-ar="نصنع الفرق"
                                data-en="Making a Difference">نصنع الفرق</span>
                            <span data-i18n="vision.titleHighlight" data-ar="بالفكرة والجودة والإبداع"
                                data-en="Through Ideas, Quality & Creativity">بالفكرة والجودة والإبداع</span>
                        </h2>

                        <p data-i18n="vision.description"
                            data-ar="نؤمن أن النجاح يبدأ من فهم احتياجات عملائنا، والاهتمام بالتفاصيل، وتقديم حلول إعلانية وطباعة رقمية تجمع بين الجودة والتميز."
                            data-en="We believe success begins with understanding our clients' needs, paying attention to every detail, and delivering advertising and digital printing solutions that combine quality and excellence.">
                            نؤمن أن النجاح يبدأ من فهم احتياجات عملائنا،
                            والاهتمام بالتفاصيل، وتقديم حلول إعلانية وطباعة رقمية
                            تجمع بين الجودة والتميز.
                        </p>
                    </div>

                    <div class="alf-vm-cards">

                        <article class="alf-vm-card alf-vm-vision">
                            <span class="alf-vm-card-number">02</span>

                            <div class="alf-vm-card-header">
                                <div class="alf-vm-card-icon">
                                    <i class="fa-regular fa-eye"></i>
                                </div>
                                <span data-i18n="vision.visionLabel" data-ar="رؤيتنا وأهدافنا"
                                    data-en="Our Vision & Goals">رؤيتنا وأهدافنا</span>
                            </div>

                            <h3>
                                <span data-i18n="vision.visionTitleFirst" data-ar="نحو مستقبل"
                                    data-en="Towards a Future">نحو مستقبل</span>
                                <span data-i18n="vision.visionTitleHighlight" data-ar="أكثر تميزاً"
                                    data-en="of Greater Excellence">أكثر تميزاً</span>
                            </h3>

                            <p data-i18n="vision.visionDescription"
                                data-ar="نطمح إلى الحصول على مركز متميز بين منافسينا، من خلال التطوير المستمر وتوظيف خبراتنا وإمكاناتنا لتقديم خدمات إعلانية وطباعة رقمية ترتقي إلى تطلعات السوق السعودي."
                                data-en="We aspire to achieve a leading position in our industry through continuous development and by leveraging our experience and capabilities to provide advertising and digital printing services that meet the expectations of the Saudi market.">
                                نطمح إلى الحصول على مركز متميز بين منافسينا،
                                من خلال التطوير المستمر وتوظيف خبراتنا وإمكاناتنا
                                لتقديم خدمات إعلانية وطباعة رقمية ترتقي إلى
                                تطلعات السوق السعودي.
                            </p>

                            <div class="alf-vm-goals">
                                <div class="alf-vm-goal">
                                    <span class="alf-vm-goal-icon">
                                        <i class="fa-solid fa-gear"></i>
                                    </span>
                                    <span data-i18n="vision.goalOne" data-ar="تطوير خدماتنا ومواكبة أحدث التقنيات."
                                        data-en="Developing our services and keeping up with the latest technologies.">
                                        تطوير خدماتنا ومواكبة أحدث التقنيات.
                                    </span>
                                </div>

                                <div class="alf-vm-goal">
                                    <span class="alf-vm-goal-icon">
                                        <i class="fa-solid fa-users"></i>
                                    </span>
                                    <span data-i18n="vision.goalTwo"
                                        data-ar="تحقيق رضا العملاء وبناء علاقات طويلة الأمد."
                                        data-en="Achieving customer satisfaction and building long-term relationships.">
                                        تحقيق رضا العملاء وبناء علاقات طويلة الأمد.
                                    </span>
                                </div>

                                <div class="alf-vm-goal">
                                    <span class="alf-vm-goal-icon">
                                        <i class="fa-solid fa-chart-line"></i>
                                    </span>
                                    <span data-i18n="vision.goalThree" data-ar="تقديم جودة عالية بأسعار منافسة."
                                        data-en="Delivering high quality at competitive prices.">
                                        تقديم جودة عالية بأسعار منافسة.
                                    </span>
                                </div>
                            </div>
                        </article>

                        <article class="alf-vm-card alf-vm-message">
                            <span class="alf-vm-card-number">01</span>

                            <div class="alf-vm-card-header">
                                <div class="alf-vm-card-icon">
                                    <i class="fa-solid fa-bullseye"></i>
                                </div>
                                <span data-i18n="vision.missionLabel" data-ar="رسالتنا"
                                    data-en="Our Mission">رسالتنا</span>
                            </div>

                            <h3>
                                <span data-i18n="vision.missionTitleFirst" data-ar="خبرة تتطور"
                                    data-en="Evolving Experience">خبرة تتطور</span>
                                <span data-i18n="vision.missionTitleHighlight" data-ar="وتقنيات تصنع الفرق"
                                    data-en="Technology That Makes a Difference">وتقنيات تصنع الفرق</span>
                            </h3>

                            <p data-i18n="vision.missionDescription"
                                data-ar="نسعى في شركة الفنان للدعاية والإعلان والطباعة الرقمية إلى تقديم حلول إبداعية متكاملة، مع الاهتمام بأدق الأمور والتفاصيل التي تصنع الفارق وتحقق رضا عملائنا."
                                data-en="At Al Fannan Advertising and Digital Printing Company, we strive to provide comprehensive creative solutions, paying attention to the smallest details that make a difference and ensure our clients' satisfaction.">
                                نسعى في شركة الفنان للدعاية والإعلان والطباعة الرقمية
                                إلى تقديم حلول إبداعية متكاملة، مع الاهتمام بأدق
                                الأمور والتفاصيل التي تصنع الفارق وتحقق رضا عملائنا.
                            </p>

                            <div class="alf-vm-message-highlight">
                                <div class="alf-vm-diamond">
                                    <i class="fa-regular fa-gem"></i>
                                </div>

                                <div>
                                    <strong data-i18n="vision.missionHighlightTitle"
                                        data-ar="الجودة والسرعة والسعر المنافس"
                                        data-en="Quality, Speed & Competitive Pricing">
                                        الجودة والسرعة والسعر المنافس
                                    </strong>
                                    <p data-i18n="vision.missionHighlightDescription"
                                        data-ar="مع الالتزام بتقديم أعمال تليق بطموحات عملائنا."
                                        data-en="Committed to delivering work that lives up to our clients' ambitions.">
                                        مع الالتزام بتقديم أعمال تليق بطموحات عملائنا.
                                    </p>
                                </div>
                            </div>
                        </article>

                    </div>
                </div>
            </div>
        </section>



        <section class="alf-services-section" id="services" dir="rtl">
            <div class="container">

                <div class="alf-services-heading">
                    <div class="alf-services-heading-content">

                        <span class="alf-services-eyebrow">
                            <i class="fa-solid fa-layer-group"></i>
                            <span data-i18n="services.eyebrow" data-ar="خدماتنا ومنتجاتنا"
                                data-en="Our Services & Products">
                                خدماتنا ومنتجاتنا
                            </span>
                        </span>

                        <h2>
                            <span class="about-highlight" data-i18n="services.titleFirst" data-ar="اكتشف خدماتنا"
                                data-en="Explore Our Services">
                                اكتشف خدماتنا
                            </span>
                            <span data-i18n="services.titleHighlight" data-ar="واختر ما يناسب احتياجك"
                                data-en="And Find What Suits Your Needs">
                                واختر ما يناسب احتياجك
                            </span>
                        </h2>

                        <p data-i18n="services.description"
                            data-ar="مجموعة متكاملة من خدمات الدعاية والإعلان والطباعة الرقمية، اختر القسم المناسب واستعرض المنتجات والتصاميم المتاحة."
                            data-en="A complete range of advertising and digital printing services. Choose the right category and explore our available products and designs.">
                            مجموعة متكاملة من خدمات الدعاية والإعلان
                            والطباعة الرقمية، اختر القسم المناسب واستعرض
                            المنتجات والتصاميم المتاحة.
                        </p>
                    </div>

                    <a href="{{ route('products.index') }}" class="alf-services-all-btn">
                        <span data-i18n="services.viewAll" data-ar="عرض جميع الخدمات" data-en="View All Services">
                            عرض جميع الخدمات
                        </span>
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                </div>

                <div class="row g-4">

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="50">

                        <a href="{{ route('products.index') }}" class="alf-service-card">

                            <div class="alf-service-icon">
                                <i class="fa-solid fa-gift"></i>
                            </div>

                            <div class="alf-service-content">
                                <h3 data-i18n="services.giftsTitle" data-ar="الهدايا الدعائية"
                                    data-en="Promotional Gifts">
                                    الهدايا الدعائية
                                </h3>

                                <p data-i18n="services.giftsDescription"
                                    data-ar="هدايا مميزة للشركات والمناسبات تحمل هوية علامتك التجارية بأسلوب احترافي."
                                    data-en="Unique gifts for companies and occasions, featuring your brand identity with a professional touch.">
                                    هدايا مميزة للشركات والمناسبات تحمل
                                    هوية علامتك التجارية بأسلوب احترافي.
                                </p>
                            </div>

                            <span class="alf-service-arrow">
                                <i class="fa-solid fa-arrow-left"></i>
                            </span>

                        </a>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">

                        <a href="{{ route('products.index') }}" class="alf-service-card">

                            <div class="alf-service-icon">
                                <i class="fa-solid fa-print"></i>
                            </div>

                            <div class="alf-service-content">
                                <h3 data-i18n="services.paperTitle" data-ar="المطبوعات الورقية"
                                    data-en="Paper Printing">
                                    المطبوعات الورقية
                                </h3>

                                <p data-i18n="services.paperDescription"
                                    data-ar="بروشورات وفلايرات وكتيبات ومطبوعات ورقية بجودة عالية وتشطيبات مميزة."
                                    data-en="Brochures, flyers, booklets, and paper prints with high quality and distinctive finishing.">
                                    بروشورات وفلايرات وكتيبات ومطبوعات
                                    ورقية بجودة عالية وتشطيبات مميزة.
                                </p>
                            </div>

                            <span class="alf-service-arrow">
                                <i class="fa-solid fa-arrow-left"></i>
                            </span>

                        </a>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="150">

                        <a href="{{ route('products.index') }}" class="alf-service-card">

                            <div class="alf-service-icon">
                                <i class="fa-solid fa-id-card"></i>
                            </div>

                            <div class="alf-service-content">
                                <h3 data-i18n="services.identityTitle" data-ar="مطبوعات الهوية"
                                    data-en="Corporate Identity Printing">
                                    مطبوعات الهوية
                                </h3>

                                <p data-i18n="services.identityDescription"
                                    data-ar="كروت شخصية وأوراق مراسلات وأظرف تعكس هوية مشروعك بصورة احترافية."
                                    data-en="Business cards, letterheads, and envelopes that reflect your brand identity professionally.">
                                    كروت شخصية وأوراق مراسلات وأظرف
                                    تعكس هوية مشروعك بصورة احترافية.
                                </p>
                            </div>

                            <span class="alf-service-arrow">
                                <i class="fa-solid fa-arrow-left"></i>
                            </span>

                        </a>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">

                        <a href="{{ route('products.index') }}" class="alf-service-card">

                            <div class="alf-service-icon">
                                <i class="fa-solid fa-box-open"></i>
                            </div>

                            <div class="alf-service-content">
                                <h3 data-i18n="services.packagingTitle" data-ar="التغليف" data-en="Packaging">
                                    التغليف
                                </h3>

                                <p data-i18n="services.packagingDescription"
                                    data-ar="علب وحقائب وبوكسات بتصاميم مبتكرة تمنح منتجاتك مظهراً مميزاً."
                                    data-en="Boxes, bags, and packages with creative designs that give your products a distinctive look.">
                                    علب وحقائب وبوكسات بتصاميم مبتكرة
                                    تمنح منتجاتك مظهراً مميزاً.
                                </p>
                            </div>

                            <span class="alf-service-arrow">
                                <i class="fa-solid fa-arrow-left"></i>
                            </span>

                        </a>
                    </div>

                </div>

                <div class="alf-services-footer">

                    <span>
                        <i class="fa-solid fa-circle-check"></i>
                        <span data-i18n="services.footerText" data-ar="خدمات متكاملة تناسب الأفراد والشركات"
                            data-en="Complete Services for Individuals and Businesses">
                            خدمات متكاملة تناسب الأفراد والشركات
                        </span>
                    </span>

                    <a href="{{ route('products.index') }}">
                        <span data-i18n="services.footerLink" data-ar="اكتشف جميع خدماتنا"
                            data-en="Explore All Our Services">
                            اكتشف جميع خدماتنا
                        </span>
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>

                </div>

            </div>
        </section>

        <section class="alf-why-section" id="why-us" dir="rtl">
            <div class="alf-why-bg"></div>
            <div class="alf-why-overlay"></div>
            <div class="alf-why-noise"></div>

            <div class="alf-why-curve alf-why-curve-right"></div>
            <div class="alf-why-curve alf-why-curve-left"></div>

            <div class="container alf-why-container">

                <div class="alf-why-heading" data-aos="fade-up">
                    <div class="alf-why-eyebrow">
                        <span class="alf-why-eyebrow-line"></span>

                        <span class="alf-why-eyebrow-text">
                            <i class="fa-solid fa-award"></i>
                            <span data-i18n="why.eyebrow" data-ar="لماذا شركة الفنان؟" data-en="Why Al Fannan?">
                                لماذا شركة الفنان؟
                            </span>
                        </span>

                        <span class="alf-why-eyebrow-line"></span>
                    </div>

                    <h2>
                        <span data-i18n="why.titleFirst" data-ar="نصنع الفرق في عالم"
                            data-en="Making a Difference in the World of">
                            نصنع الفرق في عالم
                        </span>
                        <span data-i18n="why.titleHighlight" data-ar="الدعاية والإعلان" data-en="Advertising">
                            الدعاية والإعلان
                        </span>
                    </h2>

                    <p data-i18n="why.description"
                        data-ar="نجمع بين الخبرة والإبداع وأحدث تقنيات التنفيذ لنقدم حلولاً إعلانية متكاملة تساعد علامتك التجارية على التميز والظهور بصورة تليق بها."
                        data-en="We combine experience, creativity, and the latest production technologies to deliver integrated advertising solutions that help your brand stand out and make the right impression.">
                        نجمع بين الخبرة والإبداع وأحدث تقنيات التنفيذ لنقدم
                        حلولاً إعلانية متكاملة تساعد علامتك التجارية على
                        التميز والظهور بصورة تليق بها.
                    </p>
                </div>

                <div class="row g-4 alf-why-grid">

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="50">

                        <article class="alf-why-card">
                            <span class="alf-why-number">01</span>

                            <div class="alf-why-icon">
                                <i class="fa-solid fa-users"></i>
                                <span class="alf-why-icon-star">
                                    <i class="fa-solid fa-star"></i>
                                </span>
                            </div>

                            <h3 data-i18n="why.cardOneTitle" data-ar="خبرة تتجاوز 18 عامًا"
                                data-en="Over 18 Years of Experience">
                                خبرة تتجاوز 18 عامًا
                            </h3>

                            <p data-i18n="why.cardOneDescription"
                                data-ar="خبرة طويلة في مجال الدعاية والإعلان تمنحنا القدرة على فهم احتياجات عملائنا وتحويل أفكارهم إلى نتائج مميزة."
                                data-en="Our extensive experience in advertising gives us the ability to understand our clients' needs and turn their ideas into outstanding results.">
                                خبرة طويلة في مجال الدعاية والإعلان تمنحنا
                                القدرة على فهم احتياجات عملائنا وتحويل
                                أفكارهم إلى نتائج مميزة.
                            </p>

                            <span class="alf-why-card-line"></span>
                        </article>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">

                        <article class="alf-why-card">
                            <span class="alf-why-number">02</span>

                            <div class="alf-why-icon">
                                <i class="fa-regular fa-lightbulb"></i>
                            </div>

                            <h3 data-i18n="why.cardTwoTitle" data-ar="إبداع وهوية مميزة"
                                data-en="Creativity & Distinctive Identity">
                                إبداع وهوية مميزة
                            </h3>

                            <p data-i18n="why.cardTwoDescription"
                                data-ar="نصمم هويات بصرية وحلولًا إعلانية تعكس شخصية نشاطك التجاري وتساعد علامتك على ترسيخ حضورها."
                                data-en="We create visual identities and advertising solutions that reflect your business personality and help establish a strong brand presence.">
                                نصمم هويات بصرية وحلولًا إعلانية تعكس
                                شخصية نشاطك التجاري وتساعد علامتك
                                على ترسيخ حضورها.
                            </p>

                            <span class="alf-why-card-line"></span>
                        </article>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="150">

                        <article class="alf-why-card">
                            <span class="alf-why-number">03</span>

                            <div class="alf-why-icon">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>

                            <h3 data-i18n="why.cardThreeTitle" data-ar="حلول متكاملة في مكان واحد"
                                data-en="All-in-One Solutions">
                                حلول متكاملة في مكان واحد
                            </h3>

                            <p data-i18n="why.cardThreeDescription"
                                data-ar="من التصميم والطباعة إلى اللوحات الإعلانية والهدايا والدروع والقص بالليزر، نوفر لك خيارات متنوعة."
                                data-en="From design and printing to advertising signs, gifts, awards, and laser cutting, we offer a wide range of solutions under one roof.">
                                من التصميم والطباعة إلى اللوحات الإعلانية
                                والهدايا والدروع والقص بالليزر،
                                نوفر لك خيارات متنوعة.
                            </p>

                            <span class="alf-why-card-line"></span>
                        </article>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">

                        <article class="alf-why-card">
                            <span class="alf-why-number">04</span>

                            <div class="alf-why-icon">
                                <i class="fa-solid fa-award"></i>
                            </div>

                            <h3 data-i18n="why.cardFourTitle" data-ar="جودة واهتمام بالتفاصيل"
                                data-en="Quality & Attention to Detail">
                                جودة واهتمام بالتفاصيل
                            </h3>

                            <p data-i18n="why.cardFourDescription"
                                data-ar="نهتم بجودة الخامات ودقة التنفيذ والتفاصيل النهائية لنقدم أعمالًا تعكس احترافية علامتك التجارية."
                                data-en="We focus on material quality, precise execution, and every finishing detail to deliver work that reflects your brand's professionalism.">
                                نهتم بجودة الخامات ودقة التنفيذ
                                والتفاصيل النهائية لنقدم أعمالًا
                                تعكس احترافية علامتك التجارية.
                            </p>

                            <span class="alf-why-card-line"></span>
                        </article>
                    </div>

                </div>

            </div>
        </section>

        <section class="alf-pricing" id="packages">
            <div class="alf-pricing-container">

                <div class="alf-pricing-heading" data-aos="fade-up">
                    <span class="alf-pricing-eyebrow">
                        <i class="fas fa-gift"></i>
                        <span data-i18n="pricing.eyebrow" data-ar="باقات وعروض خاصة"
                            data-en="Special Packages & Offers">باقات وعروض خاصة</span>
                    </span>

                    <h2 data-i18n="pricing.title" data-ar="باقاتنا وعروضنا المميزة"
                        data-en="Our Exclusive Packages & Offers">
                        باقاتنا وعروضنا المميزة
                    </h2>

                    <p data-i18n="pricing.description"
                        data-ar="اختر الباقة المناسبة لاحتياجاتك واستفد من حلول متكاملة تجمع بين الجودة والإبداع وأفضل الأسعار."
                        data-en="Choose the package that suits your needs and enjoy integrated solutions combining quality, creativity, and competitive prices.">
                        اختر الباقة المناسبة لاحتياجاتك واستفد من حلول متكاملة تجمع بين الجودة والإبداع وأفضل الأسعار.
                    </p>

                    <div class="alf-pricing-divider">
                        <span></span>
                        <i class="fas fa-star"></i>
                        <span></span>
                    </div>
                </div>

                <div class="alf-pricing-grid">

                    @foreach ($packages as $index => $package)
                        @php
                            $delay = ($index + 1) * 100;
                            $featuresAr = $package->features ?? [];
                            $featuresEn = $package->features_en ?? [];
                            $whatsappText = urlencode(
                                "مرحبًا، أرغب في طلب {$package->name} بسعر " .
                                    number_format($package->price, 0) .
                                    " {$package->currency}",
                            );
                        @endphp

                        <article class="alf-package-card {{ $package->is_featured ? 'alf-package-featured' : '' }}"
                            data-aos="fade-up" data-aos-delay="{{ $delay }}">

                            <div class="alf-package-icon">
                                <i class="{{ $package->icon ?: 'fas fa-box-open' }}"></i>
                            </div>

                            @if ($package->badge)
                                <span class="alf-package-badge" data-ar="{{ $package->badge }}"
                                    data-en="{{ $package->badge_en ?: $package->badge }}">
                                    @if ($package->is_featured)
                                        <i class="fas fa-crown"></i>
                                    @endif
                                    <span>{{ $package->badge }}</span>
                                </span>
                            @endif

                            <div class="alf-package-content">
                                <h3 data-ar="{{ $package->name }}"
                                    data-en="{{ $package->name_en ?: $package->name }}">
                                    {{ $package->name }}
                                </h3>

                                @if ($package->description)
                                    <p class="alf-package-description" data-ar="{{ $package->description }}"
                                        data-en="{{ $package->description_en ?: $package->description }}">
                                        {{ $package->description }}
                                    </p>
                                @endif

                                <div class="alf-package-price">
                                    <span class="alf-price-currency" data-ar="{{ $package->currency }}"
                                        data-en="{{ $package->currency === 'ر.س' ? 'SAR' : $package->currency }}">
                                        {{ $package->currency }}
                                    </span>
                                    <strong>{{ number_format($package->price, 0) }}</strong>
                                </div>

                                <div class="alf-package-separator"></div>

                                <ul class="alf-package-features">
                                    @foreach ($featuresAr as $fIndex => $featureAr)
                                        @php
                                            $featureEn = $featuresEn[$fIndex] ?? $featureAr;
                                        @endphp
                                        <li>
                                            <i class="fas fa-check"></i>
                                            <span data-ar="{{ $featureAr }}" data-en="{{ $featureEn }}">
                                                {{ $featureAr }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>

                                <a href="https://wa.me/966545953908?text={{ $whatsappText }}" class="alf-package-btn"
                                    data-package="{{ $package->id }}" data-price="{{ (float) $package->price }}"
                                    target="_blank" rel="noopener noreferrer">

                                    <span data-i18n="pricing.orderButton" data-ar="اطلب الباقة عبر واتساب"
                                        data-en="Order via WhatsApp">اطلب الباقة عبر واتساب</span>
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach

                </div>

                <div class="alf-pricing-footer" data-aos="fade-up">
                    <div class="alf-pricing-footer-icon">
                        <i class="fas fa-headset"></i>
                    </div>

                    <div class="alf-pricing-footer-text">
                        <h4 data-i18n="pricing.footerTitle" data-ar="تحتاج باقة بتصميم خاص؟"
                            data-en="Need a Custom Package?">تحتاج باقة بتصميم خاص؟</h4>
                        <p data-i18n="pricing.footerDescription"
                            data-ar="تواصل معنا وسنساعدك في اختيار الحل الأنسب لاحتياجات مشروعك."
                            data-en="Get in touch, and we'll help you choose the solution that best fits your business needs.">
                            تواصل معنا وسنساعدك في اختيار الحل الأنسب لاحتياجات مشروعك.
                        </p>
                    </div>

                    <a href="https://wa.me/966545953908" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-whatsapp"></i>
                        <span data-i18n="pricing.footerButton" data-ar="تحدث مع فريقنا"
                            data-en="Talk to Our Team">تحدث مع فريقنا</span>
                    </a>
                </div>

            </div>
        </section>

        <section class="alf-testimonials" id="testimonials">
            <div class="container">

                <div class="alf-testimonials-heading" data-aos="fade-up">
                    <span class="alf-testimonials-eyebrow">
                        <i class="fas fa-comments"></i>
                        <span data-i18n="testimonials.eyebrow" data-ar="آراء عملائنا" data-en="Customer Reviews">آراء
                            عملائنا</span>
                    </span>

                    <h2 data-i18n="testimonials.title" data-ar="ماذا يقول عملاؤنا عن الفنان؟"
                        data-en="What Do Our Customers Say About Al Fannan?">
                        ماذا يقول عملاؤنا عن الفنان؟
                    </h2>

                    <p data-i18n="testimonials.description"
                        data-ar="رضا عملائنا هو أكبر دليل على جودة خدماتنا وحرصنا الدائم على تقديم الأفضل."
                        data-en="Our customers' satisfaction is the best proof of our service quality and our commitment to always delivering the best.">
                        رضا عملائنا هو أكبر دليل على جودة خدماتنا وحرصنا الدائم على تقديم الأفضل.
                    </p>
                </div>

                <div class="alf-testimonials-rating" data-aos="fade-up">
                    <div class="alf-rating-number">
                        <strong>5.0</strong>
                        <div class="alf-rating-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span data-i18n="testimonials.ratingLabel" data-ar="تجربة عملاء مميزة"
                            data-en="Outstanding Customer Experience">تجربة عملاء مميزة</span>
                    </div>

                    <div class="alf-rating-divider"></div>

                    <div class="alf-rating-text">
                        <strong data-i18n="testimonials.ratingTitle" data-ar="نضع رضاك في المقدمة"
                            data-en="Your Satisfaction Comes First">نضع رضاك في المقدمة</strong>
                        <span data-i18n="testimonials.ratingDescription"
                            data-ar="نحرص على الجودة والدقة والالتزام في كل مشروع."
                            data-en="We prioritize quality, precision, and commitment in every project.">
                            نحرص على الجودة والدقة والالتزام في كل مشروع.
                        </span>
                    </div>
                </div>

                <div class="alf-testimonials-slider" data-aos="fade-up">
                    <div class="alf-testimonials-track" id="alfTestimonialsTrack">

                        {{-- نفس التقييمات الثلاثة تتكرر 3 مرات (9 كروت) كما كانت --}}
                        @for ($round = 0; $round < 3; $round++)
                            @foreach ($reviews as $review)
                                <article class="alf-testimonial-card">
                                    <div class="alf-testimonial-top">
                                        <div class="alf-testimonial-quote">
                                            <i class="fas fa-quote-right"></i>
                                        </div>
                                        <div class="alf-testimonial-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>

                                    <p data-i18n="testimonials.review{{ $review['n'] }}"
                                        data-ar="{{ $review['ar'] }}" data-en="{{ $review['en'] }}">
                                        {{ $review['ar'] }}
                                    </p>

                                    <div class="alf-testimonial-author">
                                        <div class="alf-testimonial-avatar">{{ $review['avatar'] }}</div>
                                        <div>
                                            <h4 data-i18n="testimonials.customer{{ $review['n'] }}"
                                                data-ar="عميلنا الكريم" data-en="Valued Customer">عميلنا الكريم</h4>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        @endfor

                    </div>
                </div>

                <div class="alf-testimonials-controls">
                    <div class="alf-testimonials-dots"></div>

                    <div class="alf-testimonials-arrows">
                        <button type="button" class="alf-testimonials-prev" aria-label="Previous">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>

                        <button type="button" class="alf-testimonials-next" aria-label="Next">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                    </div>
                </div>

                <div class="alf-testimonials-bottom" data-aos="fade-up">
                    <div>
                        <strong data-i18n="testimonials.bottomTitle" data-ar="هل ترغب في تجربة خدماتنا؟"
                            data-en="Would You Like to Experience Our Services?">
                            هل ترغب في تجربة خدماتنا؟
                        </strong>
                        <span data-i18n="testimonials.bottomDescription"
                            data-ar="يسعدنا أن نكون جزءاً من نجاح مشروعك القادم."
                            data-en="We would be delighted to be part of your next project's success.">
                            يسعدنا أن نكون جزءاً من نجاح مشروعك القادم.
                        </span>
                    </div>

                    <a href="https://wa.me/966545953908" class="btn-gold" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-whatsapp"></i>
                        <span data-i18n="testimonials.contactButton" data-ar="تواصل معنا" data-en="Contact Us">تواصل
                            معنا</span>
                    </a>
                </div>

            </div>
        </section>

        <section class="contact-section" id="contact" dir="rtl">
            <div class="container">

                <div class="contact-heading" data-aos="fade-up">
                    <span class="contact-eyebrow">
                        <i class="fas fa-envelope-open-text"></i>
                        <span data-i18n="contact.eyebrow" data-ar="تواصل معنا" data-en="Contact Us">تواصل
                            معنا</span>
                    </span>

                    <h2>
                        <span data-i18n="contact.titleFirst" data-ar="دعنا نبدأ" data-en="Let's Start">دعنا
                            نبدأ</span>
                        <span class="about-highlight" data-i18n="contact.titleHighlight" data-ar="مشروعك القادم"
                            data-en="Your Next Project">مشروعك القادم</span>
                    </h2>

                    <p data-i18n="contact.description"
                        data-ar="لديك فكرة إعلانية أو تحتاج إلى حلول طباعة وتصميم؟ يسعدنا التواصل معك ومساعدتك في اختيار الحل المناسب."
                        data-en="Have an advertising idea or need printing and design solutions? We'd be happy to hear from you and help you choose the right solution.">
                        لديك فكرة إعلانية أو تحتاج إلى حلول طباعة وتصميم؟
                        يسعدنا التواصل معك ومساعدتك في اختيار الحل المناسب.
                    </p>
                </div>

                <div class="contact-wrapper" data-aos="fade-up" data-aos-delay="100">

                    <div class="contact-form-panel">
                        <div class="contact-form-heading">
                            <span class="contact-form-icon">
                                <i class="fas fa-paper-plane"></i>
                            </span>

                            <div>
                                <h3 data-i18n="contact.formTitle" data-ar="أرسل لنا رسالة"
                                    data-en="Send Us a Message">أرسل لنا رسالة</h3>
                                <p data-i18n="contact.formDescription" data-ar="املأ البيانات التالية وسنتواصل معك."
                                    data-en="Fill in the details below and we'll get in touch with you.">
                                    املأ البيانات التالية وسنتواصل معك.
                                </p>
                            </div>
                        </div>

                        <form id="contactForm" class="contact-form">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label for="contactName" data-i18n="contact.nameLabel" data-ar="الاسم الكامل"
                                        data-en="Full Name">
                                        الاسم الكامل
                                    </label>

                                    <div class="contact-input-wrap">
                                        <i class="fas fa-user"></i>
                                        <input type="text" id="contactName" name="name"
                                            placeholder="اكتب اسمك" data-ar-placeholder="اكتب اسمك"
                                            data-en-placeholder="Enter your name"
                                            data-i18n-placeholder="contact.namePlaceholder" autocomplete="name"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="contactPhone" data-i18n="contact.phoneLabel" data-ar="رقم الجوال"
                                        data-en="Mobile Number">
                                        رقم الجوال
                                    </label>

                                    <div class="contact-input-wrap">
                                        <i class="fas fa-phone"></i>
                                        <input type="tel" id="contactPhone" name="phone"
                                            placeholder="05xxxxxxxx" data-i18n-placeholder="contact.phonePlaceholder"
                                            autocomplete="tel" inputmode="tel" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="contactService" data-i18n="contact.serviceLabel" data-ar="نوع الخدمة"
                                        data-en="Service Type">
                                        نوع الخدمة
                                    </label>

                                    <div class="contact-input-wrap">
                                        <i class="fas fa-layer-group"></i>

                                        <select id="contactService" name="service" required>
                                            <option value="" selected disabled
                                                data-i18n="contact.servicePlaceholder" data-ar="اختر الخدمة المطلوبة"
                                                data-en="Select the Required Service">
                                                اختر الخدمة المطلوبة
                                            </option>

                                            <option value="تصميم وطباعة الهويات البصرية"
                                                data-i18n="contact.serviceIdentity"
                                                data-ar="تصميم وطباعة الهويات البصرية"
                                                data-en="Visual Identity Design & Printing">
                                                تصميم وطباعة الهويات البصرية
                                            </option>

                                            <option value="البنرات والملصقات" data-i18n="contact.serviceBanners"
                                                data-ar="البنرات والملصقات" data-en="Banners & Stickers">
                                                البنرات والملصقات
                                            </option>

                                            <option value="اللوحات الإعلانية والكلادينج"
                                                data-i18n="contact.serviceSignage"
                                                data-ar="اللوحات الإعلانية والكلادينج"
                                                data-en="Advertising Signs & Cladding">
                                                اللوحات الإعلانية والكلادينج
                                            </option>

                                            <option value="الدروع والهدايا" data-i18n="contact.serviceGifts"
                                                data-ar="الدروع والهدايا" data-en="Awards & Gifts">
                                                الدروع والهدايا
                                            </option>

                                            <option value="القص والحفر بالليزر" data-i18n="contact.serviceLaser"
                                                data-ar="القص والحفر بالليزر" data-en="Laser Cutting & Engraving">
                                                القص والحفر بالليزر
                                            </option>

                                            <option value="خدمات الحج والعمرة" data-i18n="contact.serviceHajj"
                                                data-ar="خدمات الحج والعمرة" data-en="Hajj & Umrah Services">
                                                خدمات الحج والعمرة
                                            </option>

                                            <option value="خدمة أخرى" data-i18n="contact.serviceOther"
                                                data-ar="خدمة أخرى" data-en="Other Service">
                                                خدمة أخرى
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="contactMessage" data-i18n="contact.messageLabel"
                                        data-ar="تفاصيل طلبك" data-en="Your Request Details">
                                        تفاصيل طلبك
                                    </label>

                                    <div class="contact-input-wrap contact-textarea-wrap">
                                        <i class="fas fa-comment-dots"></i>
                                        <textarea id="contactMessage" name="message" rows="4" placeholder="أخبرنا بالمزيد عن مشروعك أو طلبك..."
                                            data-i18n-placeholder="contact.messagePlaceholder" required></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="contact-submit">
                                        <span data-i18n="contact.submitBtn" data-ar="إرسال الرسالة"
                                            data-en="Send Message">إرسال الرسالة</span>
                                        <i class="fas fa-arrow-left"></i>
                                    </button>

                                    <p class="contact-form-status" id="contactFormStatus" role="status"
                                        aria-live="polite"></p>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-info-overlay"></div>

                        <div class="contact-info-content">
                            <span class="contact-info-label">
                                <i class="fas fa-headset"></i>
                                <span data-i18n="contact.infoEyebrow" data-ar="نحن هنا لمساعدتك"
                                    data-en="We're Here to Help">
                                    نحن هنا لمساعدتك
                                </span>
                            </span>

                            <h3>
                                <span data-i18n="contact.infoTitleFirst" data-ar="فكرتك تستحق"
                                    data-en="Your Idea Deserves">
                                    فكرتك تستحق
                                </span>
                                <span data-i18n="contact.infoTitleHighlight" data-ar="تنفيذًا مميزًا"
                                    data-en="Outstanding Execution">
                                    تنفيذًا مميزًا
                                </span>
                            </h3>

                            <p class="contact-info-description" data-i18n="contact.infoDescription"
                                data-ar="تواصل مع فريق شركة الفنان للدعاية والإعلان، ودعنا نساعدك في تحويل أفكارك إلى تصاميم ومطبوعات وحلول إعلانية احترافية."
                                data-en="Get in touch with the Al Fannan Advertising team and let us help turn your ideas into professional designs, prints, and advertising solutions.">
                                تواصل مع فريق شركة الفنان للدعاية والإعلان،
                                ودعنا نساعدك في تحويل أفكارك إلى تصاميم
                                ومطبوعات وحلول إعلانية احترافية.
                            </p>

                            <div class="contact-info-list">

                                <a href="tel:+966545953908" class="contact-info-item">
                                    <span class="contact-info-item-icon">
                                        <i class="fas fa-phone-alt"></i>
                                    </span>

                                    <span class="contact-info-item-text">
                                        <small data-i18n="contact.callLabel" data-ar="اتصل بنا"
                                            data-en="Call Us">اتصل بنا</small>
                                        <strong dir="ltr">966545953908</strong>
                                    </span>

                                    <i class="fas fa-arrow-up contact-info-arrow"></i>
                                </a>

                                <a href="mailto:alfanaan.adv2@gmail.com" class="contact-info-item">
                                    <span class="contact-info-item-icon">
                                        <i class="fas fa-envelope"></i>
                                    </span>

                                    <span class="contact-info-item-text">
                                        <small data-i18n="contact.emailLabel" data-ar="البريد الإلكتروني"
                                            data-en="Email Address">البريد الإلكتروني</small>
                                        <strong dir="ltr">alfanaan.adv2@gmail.com</strong>
                                    </span>

                                    <i class="fas fa-arrow-up contact-info-arrow"></i>
                                </a>

                                <div class="contact-info-item">
                                    <span class="contact-info-item-icon">
                                        <i class="fas fa-location-dot"></i>
                                    </span>

                                    <span class="contact-info-item-text">
                                        <small data-i18n="contact.locationLabel" data-ar="موقعنا"
                                            data-en="Our Location">موقعنا</small>
                                        <strong data-i18n="contact.address"
                                            data-ar="مكة المكرمة - الشوقية - شارع أبرهة بن شرحبيل بجوار جامع المهاجرين"
                                            data-en="Makkah - Al Shawqiyyah - Abrahah bin Shurahbil Street, next to Al Muhajireen Mosque">
                                            مكة المكرمة - الشوقية - شارع أبرهة بن شرحبيل
                                            بجوار جامع المهاجرين
                                        </strong>
                                    </span>
                                </div>

                            </div>

                            <div class="contact-info-footer">
                                <span data-i18n="contact.followLabel" data-ar="تابعنا وتواصل معنا"
                                    data-en="Follow Us & Stay Connected">
                                    تابعنا وتواصل معنا
                                </span>

                                <div class="contact-social-links">
                                    <a href="https://www.instagram.com/alfananmakkah?dlrf=MXhwNjA1N2U0OG9uOQ=="
                                        target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>

                                    <a href="https://wa.me/966545953908" target="_blank" rel="noopener noreferrer"
                                        aria-label="WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="location-wrapper mt-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="location-map">

                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3714.991229523252!2d39.79232768506134!3d21.390249985803674!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjHCsDIzJzI0LjkiTiAzOcKwNDcnMjQuNSJF!5e0!3m2!1sar!2seg!4v1792419112432!5m2!1sar!2seg"
                            title="موقع شركة الفنان للدعاية والإعلان على خرائط Google"
                            data-i18n-title="contact.mapTitle" width="100%" height="100%" style="border: 0;"
                            allowfullscreen loading="lazy" referrerpolicy="strict-origin-when-cross-origin">
                        </iframe>

                        <span class="location-map-label">
                            <i class="fas fa-map-marked-alt"></i>
                            <span data-i18n="contact.locationLabel" data-ar="موقعنا"
                                data-en="Our Location">موقعنا</span>
                        </span>

                    </div>
                </div>

            </div>
        </section>
        @php
            $logoGroups = [
                [
                    'id' => 'clients',
                    'title_ar' => 'العملاء والشركاء',
                    'title_en' => 'Our Clients',
                    'sub_ar' => 'ثقة عملائنا هي أساس نجاحنا',
                    'sub_en' => 'Our clients\' trust is the foundation of our success',
                    'items' => $clients ?? collect(),
                ],
            ];
        @endphp

        <section class="logos-section py-5" id="partners-clients" dir="rtl">
            <div class="container">

                @foreach ($logoGroups as $group)
                    @continue($group['items']->isEmpty())

                    <div class="logos-group {{ !$loop->last ? 'mb-5' : '' }}" id="{{ $group['id'] }}"
                        data-aos="fade-up">

                        <div class="logos-heading text-center mb-4">
                            <h2 class="logos-title" data-ar="{{ $group['title_ar'] }}"
                                data-en="{{ $group['title_en'] }}">
                                {{ $group['title_ar'] }}
                            </h2>
                            <p class="logos-subtitle mb-0" data-ar="{{ $group['sub_ar'] }}"
                                data-en="{{ $group['sub_en'] }}">
                                {{ $group['sub_ar'] }}
                            </p>
                            <span class="logos-line"></span>
                        </div>

                        <div class="row g-3 g-md-4 justify-content-center">
                            @foreach ($group['items'] as $item)
                                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                    <div class="logo-card" title="{{ $item->name }}">
                                        <img src="{{ asset('storage/' . $item->logo) }}" alt="{{ $item->name }}"
                                            class="logo-img" loading="lazy">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </section>

        <style>
            .logos-section {
                --logos-gold: var(--gold, #b08a5a);
                --logos-gold-dark: var(--gold-dark, #8f6b43);
                --logos-ink: var(--dark, #33343f);
                position: relative;
                overflow: hidden;
                color: var(--logos-ink);
                background:
                    radial-gradient(circle at 95% 8%, rgba(176, 138, 90, .16), transparent 35%),
                    radial-gradient(circle at 5% 95%, rgba(176, 138, 90, .14), transparent 38%),
                    linear-gradient(135deg, #fdfaf6 0%, #f6eee5 100%);
            }

            /* شكل زخرفي بنفس لمسة صورة "من نحن" */
            .logos-section::before {
                content: "";
                position: absolute;
                top: -90px;
                left: -70px;
                width: 260px;
                height: 260px;
                background: linear-gradient(160deg, #cdb08a, #b08a5a);
                opacity: .28;
                border-radius: 60px 120px 60px 120px;
                transform: rotate(-12deg);
                pointer-events: none;
            }

            .logos-section::after {
                content: "";
                position: absolute;
                bottom: -110px;
                right: -80px;
                width: 280px;
                height: 280px;
                border: 2px solid rgba(176, 138, 90, .35);
                border-radius: 90px 40px 90px 40px;
                transform: rotate(10deg);
                pointer-events: none;
            }

            .logos-section .container {
                position: relative;
                z-index: 1;
            }

            .logos-title {
                font-weight: 800;
                font-size: 1.9rem;
                margin-bottom: .4rem;
                color: var(--logos-ink);
            }

            .logos-subtitle {
                color: var(--logos-gold-dark);
                font-weight: 600;
            }

            .logos-line {
                display: block;
                width: 70px;
                height: 3px;
                margin: .9rem auto 0;
                background: linear-gradient(90deg, transparent, var(--logos-gold), transparent);
                border-radius: 3px;
            }

            .logo-card {
                height: 130px;
                padding: 18px 22px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #fff;
                border: 1px solid rgba(176, 138, 90, .18);
                border-radius: 18px;
                box-shadow: 0 6px 18px rgba(120, 90, 55, .07);
                transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
            }

            .logo-card:hover {
                transform: translateY(-5px);
                border-color: var(--logos-gold);
                box-shadow: 0 14px 30px rgba(120, 90, 55, .18);
            }

            .logo-img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                filter: grayscale(100%);
                opacity: .8;
                transition: filter .25s ease, opacity .25s ease;
            }

            .logo-card:hover .logo-img {
                filter: grayscale(0);
                opacity: 1;
            }

            @media (max-width: 575.98px) {
                .logo-card {
                    height: 105px;
                    padding: 14px;
                }
            }
        </style>

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
                                    <span data-i18n="footer.home" data-ar="الرئيسية"
                                        data-en="Home">الرئيسية</span>
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
                                    <span data-i18n="footer.contact" data-ar="تواصل معنا"
                                        data-en="Contact Us">تواصل
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
                    <span data-i18n="footer.featurePrices" data-ar="أسعار منافسة"
                        data-en="Competitive Prices">أسعار منافسة</span>
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

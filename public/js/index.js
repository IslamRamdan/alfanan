document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const $ = (selector, parent = document) => parent.querySelector(selector);
    const $$ = (selector, parent = document) => [
        ...parent.querySelectorAll(selector),
    ];

    const whatsappNumber = "966545953908";

    const LANGUAGE_STORAGE_KEY = "alf-language";

    const storedLanguage = localStorage.getItem(LANGUAGE_STORAGE_KEY);

    const initialLanguage = ["ar", "en"].includes(storedLanguage)
        ? storedLanguage
        : "ar";

    document.documentElement.lang = initialLanguage;
    document.documentElement.dir = initialLanguage === "ar" ? "rtl" : "ltr";

    const getLang = () =>
        document.documentElement.lang.toLowerCase().startsWith("en")
            ? "en"
            : "ar";

    const isEnglish = () => getLang() === "en";
    const translate = (ar, en) => (isEnglish() ? en : ar);

    function translatePage() {
        const lang = getLang();

        $$("[data-ar][data-en]").forEach((element) => {
            const value = element.dataset[lang];

            if (value !== undefined) {
                element.textContent = value;
            }
        });

        [
            ["data-ar-placeholder", "data-en-placeholder", "placeholder"],
            ["data-ar-title", "data-en-title", "title"],
            ["data-ar-alt", "data-en-alt", "alt"],
            ["data-ar-value", "data-en-value", "value"],
        ].forEach(([arAttribute, enAttribute, property]) => {
            $$(`[${arAttribute}][${enAttribute}]`).forEach((element) => {
                const value = element.getAttribute(
                    lang === "ar" ? arAttribute : enAttribute,
                );

                if (value !== null) {
                    element[property] = value;
                }
            });
        });

        $$("[data-lang-switch]").forEach((button) => {
            const active = button.dataset.langSwitch === lang;

            button.classList.toggle("active", active);
            button.setAttribute("aria-pressed", String(active));
        });
    }

    const mobileToggle = $("#mobileToggle");
    const mainNav = $("#mainNav");
    const searchToggle = $(".search-toggle");
    const searchPanel = $("#searchPanel");
    const searchInput = $("#searchInput");

    const hero = $(".hero");
    const heroSlides = $$(".hero-slide");
    const heroDots = $$(".hero-dot");
    const prevButton = $("#prevSlide");
    const nextButton = $("#nextSlide");
    const currentSlideNumber = $("#currentSlide");
    const slideProgress = $("#slideProgress");

    let currentSlide = 0;
    let heroTimer = null;
    let touchStartX = 0;
    let lastObservedLanguage = getLang();

    const heroInterval = 4000;

    const escapeHTML = (value) =>
        String(value ?? "").replace(
            /[&<>"']/g,
            (character) =>
                ({
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#39;",
                })[character],
        );

    const categories = [
        {
            key: "gifts",
            title: "الهدايا الدعائية",
            columns: [
                [
                    ["awards", "دروع تذكارية", "fa-award"],
                    ["nameBadge", "بروش اسم", "fa-id-badge"],
                    ["deskNameplate", "لوحة اسم مكتبية", "fa-address-card"],
                    ["mugPrinting", "طباعة أكواب", "fa-mug-hot"],
                    ["penPrinting", "طباعة أقلام", "fa-pen"],
                    ["usbPrinting", "طباعة فلاش", "fa-usb"],
                    ["calendar", "تقويم", "fa-calendar-days"],
                ],
                [
                    ["carSunshade", "شماسة سيارة", "fa-car-side"],
                    ["candles", "شموع", "fa-fire-flame-curved"],
                    ["plotterPrinting", "طباعة ورق بلوت", "fa-scroll"],
                    ["sashPrinting", "طباعة وشاح", "fa-ribbon"],
                    ["puzzlePrinting", "طباعة بازل", "fa-puzzle-piece"],
                    ["notepad", "مذكرة", "fa-book-open"],
                    ["carFreshener", "طباعة معطر سيارة", "fa-spray-can"],
                    ["mousePad", "ماوس باد", "fa-computer-mouse"],
                ],
            ],
        },
        {
            key: "printing",
            title: "المطبوعات الورقية",
            columns: [
                [
                    ["certificate", "شهادة شكر وتقدير", "fa-certificate"],
                    ["books", "كتب", "fa-book"],
                    ["businessCards", "كروت شخصية", "fa-address-card"],
                    ["restaurantMenu", "منيو المطاعم", "fa-utensils"],
                    ["brochures", "بروشورات", "fa-book-open"],
                    ["invoices", "فواتير", "fa-file-invoice"],
                    ["notebook", "نوت بوك", "fa-book-bookmark"],
                ],
                [
                    ["letterhead", "ورق مراسلات", "fa-file-lines"],
                    ["envelopes", "الأظرف", "fa-envelope"],
                    ["vouchers", "سندات", "fa-receipt"],
                    ["leaflets", "مطويات", "fa-file"],
                    ["contracts", "عقود", "fa-file-signature"],
                    ["greetingCards", "كروت التهنئة والزواج", "fa-heart"],
                ],
                [
                    ["calendar", "تقويم", "fa-calendar-days"],
                    ["folders", "فولدر", "fa-folder-open"],
                    ["placemats", "ورق سفرة", "fa-plate-wheat"],
                    ["bookmarks", "فواصل كتب", "fa-bookmark"],
                    ["companyProfile", "البروفايل", "fa-id-card"],
                ],
            ],
        },
        {
            key: "identity",
            title: "مطبوعات الهوية",
            columns: [
                [
                    ["stickers", "استكرات لاصقة", "fa-note-sticky"],
                    ["businessCard", "بطاقة العمل", "fa-address-card"],
                    ["curtainPrinting", "طباعة ستائر", "fa-window-maximize"],
                    ["stamps", "أختام", "fa-stamp"],
                    ["tshirtPrinting", "طباعة تيشرتات", "fa-shirt"],
                ],
                [
                    ["capEmbroidery", "تطريز كاب", "fa-hat-cowboy"],
                    ["sweatshirtPrinting", "طباعة بلوفرات", "fa-shirt"],
                    ["balloonPrinting", "طباعة على البالونات", "fa-gift"],
                    ["fabricLabels", "ليبل قماش", "fa-tag"],
                    ["fabricBags", "شنط قماش", "fa-bag-shopping"],
                ],
                [
                    ["safetyVest", "سترة سلامة", "fa-vest"],
                    ["waistcoats", "سديريات", "fa-vest-patches"],
                    ["aprons", "مريلة", "fa-user-tie"],
                    ["file", "ملف", "fa-folder-open"],
                    ["tags", "تاقات", "fa-tags"],
                ],
            ],
        },
        {
            key: "packaging",
            title: "التغليف",
            columns: [
                [
                    ["plasticCups", "أكواب بلاستيك", "fa-glass-water"],
                    ["paperCups", "أكواب ورقية", "fa-mug-hot"],
                    ["paperBags", "أكياس ورقية", "fa-bag-shopping"],
                ],
                [
                    ["shippingBags", "طباعة أكياس شحن", "fa-box"],
                    ["ribbonPrinting", "طباعة شرائط", "fa-ribbon"],
                    ["tissuePrinting", "طباعة مناديل", "fa-box-tissue"],
                ],
            ],
        },
        {
            key: "exhibitions",
            title: "تنظيم المعارض",
            columns: [
                [
                    ["stands", "ستاند", "fa-display"],
                    ["popupDisplays", "بوب أب", "fa-panorama"],
                    ["flags", "أعلام", "fa-flag"],
                ],
                [
                    ["tickets", "تذاكر", "fa-ticket"],
                    ["tableCards", "كرت طاولة", "fa-table"],
                    ["wristbands", "أساور", "fa-id-badge"],
                ],
            ],
        },
        {
            key: "occasions",
            title: "عروض المناسبات",
            columns: [
                [
                    ["eidGifts", "توزيعات العيد", "fa-gift"],
                    ["newbornGifts", "توزيعات المواليد", "fa-baby"],
                    ["nationalDay", "اليوم الوطني", "fa-flag"],
                ],
                [
                    ["foundingDay", "يوم التأسيس", "fa-landmark"],
                    ["ramadanGifts", "توزيعات رمضان", "fa-moon"],
                    ["engagementGifts", "توزيعات ملكة", "fa-ring"],
                    ["schoolGifts", "توزيعات العودة للمدارس", "fa-school"],
                ],
                [["graduationGifts", "توزيعات التخرج", "fa-graduation-cap"]],
            ],
        },
        {
            key: "signage",
            title: "اللوحات الإعلانية",
            columns: [
                [
                    ["banners", "بنر", "fa-scroll"],
                    ["posters", "بوستر", "fa-image"],
                    ["raisedLetters", "حروف بارزة", "fa-font"],
                    ["acrylicSigns", "لوحة أكريليك", "fa-sign-hanging"],
                ],
                [
                    ["pvcShelfTags", "تعليقة رفوف PVC", "fa-tags"],
                    ["foamPrinting", "طباعة على فلين", "fa-layer-group"],
                    ["forexSigns", "لوحة فوركس", "fa-table-cells-large"],
                ],
            ],
        },
        {
            key: "design",
            title: "التصميم",
            columns: [
                [
                    ["adDesign", "تصميم إعلان", "fa-rectangle-ad"],
                    ["brochureDesign", "تصميم البروشورات", "fa-book-open"],
                    ["cvDesign", "تصميم سيرة ذاتية", "fa-file-lines"],
                ],
                [
                    ["logoDesign", "تصميم شعار", "fa-pen-nib"],
                    [
                        "businessCardDesign",
                        "تصميم كروت شخصية",
                        "fa-address-card",
                    ],
                    ["brandIdentityDesign", "تصميم هوية تجارية", "fa-palette"],
                ],
                [
                    [
                        "greetingCardDesign",
                        "تصميم كروت التهنئة والزواج",
                        "fa-heart",
                    ],
                    [
                        "schoolFolderDesign",
                        "تصميم ملفات مدرسية",
                        "fa-folder-open",
                    ],
                    ["menuDesign", "تصميم منيو", "fa-utensils"],
                ],
            ],
        },
    ];

    const megaMenuContainer = $("#navCategories");

    const megaMenuEnglish = {
        categories: {
            gifts: "Promotional Gifts",
            printing: "Paper Printing",
            identity: "Identity Printing",
            packaging: "Packaging",
            exhibitions: "Exhibition Organization",
            occasions: "Occasion Gifts",
            signage: "Advertising Signs",
            design: "Design",
        },
        items: {
            awards: "Commemorative Awards",
            nameBadge: "Name Badges",
            deskNameplate: "Desk Nameplates",
            mugPrinting: "Custom Mug Printing",
            penPrinting: "Custom Pen Printing",
            usbPrinting: "USB Flash Drive Printing",
            calendar: "Calendars",
            carSunshade: "Car Sunshades",
            candles: "Candles",
            plotterPrinting: "Plotter Paper Printing",
            sashPrinting: "Sash Printing",
            puzzlePrinting: "Custom Puzzles",
            notepad: "Notepads",
            carFreshener: "Car Air Freshener Printing",
            mousePad: "Mouse Pads",
            certificate: "Certificates of Appreciation",
            books: "Books",
            businessCards: "Business Cards",
            restaurantMenu: "Restaurant Menus",
            brochures: "Brochures",
            invoices: "Invoices",
            notebook: "Notebooks",
            letterhead: "Letterheads",
            envelopes: "Envelopes",
            vouchers: "Vouchers",
            leaflets: "Leaflets",
            contracts: "Contracts",
            greetingCards: "Greeting & Wedding Cards",
            folders: "Folders",
            placemats: "Placemats",
            bookmarks: "Bookmarks",
            companyProfile: "Company Profiles",
            stickers: "Adhesive Stickers",
            businessCard: "Business Cards",
            curtainPrinting: "Curtain Printing",
            stamps: "Stamps",
            tshirtPrinting: "T-Shirt Printing",
            capEmbroidery: "Cap Embroidery",
            sweatshirtPrinting: "Sweatshirt Printing",
            balloonPrinting: "Balloon Printing",
            fabricLabels: "Fabric Labels",
            fabricBags: "Fabric Bags",
            safetyVest: "Safety Vests",
            waistcoats: "Waistcoats",
            aprons: "Aprons",
            file: "Files",
            tags: "Tags",
            plasticCups: "Plastic Cups",
            paperCups: "Paper Cups",
            paperBags: "Paper Bags",
            shippingBags: "Shipping Bag Printing",
            ribbonPrinting: "Ribbon Printing",
            tissuePrinting: "Tissue Printing",
            stands: "Display Stands",
            popupDisplays: "Pop-up Displays",
            flags: "Flags",
            tickets: "Tickets",
            tableCards: "Table Cards",
            wristbands: "Wristbands",
            eidGifts: "Eid Gifts",
            newbornGifts: "Newborn Gifts",
            nationalDay: "National Day Gifts",
            foundingDay: "Founding Day Gifts",
            ramadanGifts: "Ramadan Gifts",
            engagementGifts: "Engagement Gifts",
            schoolGifts: "Back-to-School Gifts",
            graduationGifts: "Graduation Gifts",
            banners: "Banners",
            posters: "Posters",
            raisedLetters: "3D Raised Letters",
            acrylicSigns: "Acrylic Signs",
            pvcShelfTags: "PVC Shelf Labels",
            foamPrinting: "Foam Board Printing",
            forexSigns: "Forex Signs",
            adDesign: "Advertisement Design",
            brochureDesign: "Brochure Design",
            cvDesign: "CV Design",
            logoDesign: "Logo Design",
            businessCardDesign: "Business Card Design",
            brandIdentityDesign: "Brand Identity Design",
            greetingCardDesign: "Greeting & Wedding Card Design",
            schoolFolderDesign: "School Folder Design",
            menuDesign: "Menu Design",
        },
        viewProducts: "View Products",
    };

    function translatedCategories() {
        if (!isEnglish()) return categories;

        return categories.map((category) => ({
            ...category,
            title: megaMenuEnglish.categories[category.key] || category.title,
            columns: category.columns.map((column) =>
                column.map(([key, title, icon]) => [
                    key,
                    megaMenuEnglish.items[key] || title,
                    icon,
                ]),
            ),
        }));
    }

    function createMegaProduct([key, title, icon]) {
        const viewProducts = translate(
            "عرض المنتجات",
            megaMenuEnglish.viewProducts,
        );

        return `
            <div class="nav-dropdown mega-sub-dropdown">
                <button
                    class="mega-sub-trigger dropdown-trigger"
                    type="button"
                    aria-expanded="false"
                >
                    <i class="fa-solid ${escapeHTML(icon)}"></i>
                    <span>${escapeHTML(title)}</span>
                    <i class="fa-solid fa-chevron-down mega-sub-arrow"></i>
                </button>

                <div class="mega-menu mega-sub-menu">
                    <div class="mega-menu-content">
                        <a href="/products">
                            <i class="fa-solid fa-box-open"></i>
                            <span>${escapeHTML(viewProducts)}</span>
                        </a>
                    </div>
                </div>
            </div>
        `;
    }

    function renderMegaMenu() {
        if (!megaMenuContainer) return;

        megaMenuContainer.innerHTML = translatedCategories()
            .map(
                (category) => `
                <div class="nav-dropdown">
                    <button
                        class="nav-link dropdown-trigger"
                        type="button"
                        aria-expanded="false"
                    >
                        <span>${escapeHTML(category.title)}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>

                    <div class="mega-menu">
                        ${category.columns
                            .map(
                                (column, index) => `
                            <div class="mega-menu-content">
                                ${
                                    index === 0
                                        ? `
                                    <span class="mega-label">
                                        ${escapeHTML(category.title)}
                                    </span>
                                `
                                        : ""
                                }

                                ${column.map(createMegaProduct).join("")}
                            </div>
                        `,
                            )
                            .join("")}
                    </div>
                </div>
            `,
            )
            .join("");
    }

    function setLanguage(lang) {
        if (!["ar", "en"].includes(lang)) return;

        document.documentElement.lang = lang;
        document.documentElement.dir = lang === "ar" ? "rtl" : "ltr";

        localStorage.setItem(LANGUAGE_STORAGE_KEY, lang);

        translatePage();
        renderMegaMenu();
        updateLanguage();
        updateLanguageSwitcher();

        document.dispatchEvent(
            new CustomEvent("languageChanged", {
                detail: { lang },
            }),
        );
    }

    window.setLanguage = setLanguage;

    // Language Switcher

    const languageSwitcher = $("#languageSwitcher");
    const languageSwitcherBtn = $("#languageSwitcherBtn");
    const languageSwitcherMenu = $("#languageSwitcherMenu");

    const currentLangFlag = $("#currentLangFlag");
    const currentLangCode = $("#currentLangCode");

    const languageOptions = $$(".language-option");

    function updateLanguageSwitcher() {
        const lang = getLang();

        if (currentLangFlag) {
            currentLangFlag.textContent = lang === "ar" ? "🇸🇦" : "🇺🇸";
        }

        if (currentLangCode) {
            currentLangCode.textContent = lang.toUpperCase();
        }

        languageOptions.forEach((option) => {
            const active = option.dataset.lang === lang;

            option.classList.toggle("active", active);
            option.setAttribute("aria-pressed", String(active));
        });
    }

    function openLanguageMenu() {
        if (!languageSwitcher || !languageSwitcherBtn) return;

        languageSwitcher.classList.add("is-open");
        languageSwitcherBtn.setAttribute("aria-expanded", "true");
    }

    function closeLanguageMenu() {
        if (!languageSwitcher || !languageSwitcherBtn) return;

        languageSwitcher.classList.remove("is-open");
        languageSwitcherBtn.setAttribute("aria-expanded", "false");
    }

    function toggleLanguageMenu() {
        if (!languageSwitcher) return;

        const isOpen = languageSwitcher.classList.contains("is-open");

        if (isOpen) {
            closeLanguageMenu();
        } else {
            openLanguageMenu();
        }
    }

    languageSwitcherBtn?.addEventListener("click", (event) => {
        event.preventDefault();
        event.stopPropagation();

        toggleLanguageMenu();
    });

    languageOptions.forEach((option) => {
        option.addEventListener("click", (event) => {
            event.preventDefault();
            event.stopPropagation();

            const lang = option.dataset.lang;

            if (!["ar", "en"].includes(lang)) return;

            setLanguage(lang);
            closeLanguageMenu();
        });
    });

    document.addEventListener("click", (event) => {
        if (languageSwitcher && !languageSwitcher.contains(event.target)) {
            closeLanguageMenu();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeLanguageMenu();
        }
    });

    // Navigation Dropdowns

    function setDropdownOpen(dropdown, open) {
        if (!dropdown) return;

        dropdown.classList.toggle("is-open", open);

        const trigger = dropdown.querySelector(":scope > .dropdown-trigger");

        trigger?.setAttribute("aria-expanded", String(open));

        if (!open) {
            dropdown
                .querySelectorAll(".nav-dropdown.is-open")
                .forEach((child) => {
                    child.classList.remove("is-open");

                    child
                        .querySelector(":scope > .dropdown-trigger")
                        ?.setAttribute("aria-expanded", "false");
                });
        }
    }

    function closeDropdowns(except = null) {
        if (!mainNav) return;

        $$(".nav-dropdown.is-open", mainNav).forEach((dropdown) => {
            if (dropdown === except || (except && dropdown.contains(except))) {
                return;
            }

            setDropdownOpen(dropdown, false);
        });
    }

    function closeSiblingDropdowns(dropdown) {
        if (!dropdown?.parentElement) return;

        [...dropdown.parentElement.children].forEach((sibling) => {
            if (
                sibling !== dropdown &&
                sibling.classList.contains("nav-dropdown")
            ) {
                setDropdownOpen(sibling, false);
            }
        });
    }

    if (mainNav) {
        mainNav.addEventListener("click", (event) => {
            const trigger = event.target.closest(".dropdown-trigger");

            if (!trigger || !mainNav.contains(trigger)) return;

            event.preventDefault();
            event.stopPropagation();

            const dropdown = trigger.closest(".nav-dropdown");

            if (!dropdown) return;

            const shouldOpen = !dropdown.classList.contains("is-open");

            closeSiblingDropdowns(dropdown);
            setDropdownOpen(dropdown, shouldOpen);
        });

        mainNav.addEventListener("pointerover", (event) => {
            if (
                !window.matchMedia("(min-width: 1200px) and (hover: hover)")
                    .matches
            )
                return;

            const dropdown = event.target.closest(".nav-dropdown");

            if (!dropdown || !mainNav.contains(dropdown)) return;

            if (event.relatedTarget && dropdown.contains(event.relatedTarget)) {
                return;
            }

            closeSiblingDropdowns(dropdown);
            setDropdownOpen(dropdown, true);
        });

        mainNav.addEventListener("pointerout", (event) => {
            if (
                !window.matchMedia("(min-width: 1200px) and (hover: hover)")
                    .matches
            )
                return;

            const dropdown = event.target.closest(".nav-dropdown");

            if (!dropdown || !mainNav.contains(dropdown)) return;

            if (event.relatedTarget && dropdown.contains(event.relatedTarget)) {
                return;
            }

            setDropdownOpen(dropdown, false);
        });

        mainNav.addEventListener("click", (event) => {
            const link = event.target.closest("a");

            if (!link) return;

            if (window.innerWidth < 1200) {
                closeMobileMenu();
            }
        });
    }

    function closeMobileMenu() {
        if (!mainNav || !mobileToggle) return;

        mainNav.classList.remove("is-open");
        mobileToggle.classList.remove("is-active");

        mobileToggle.setAttribute("aria-expanded", "false");

        mobileToggle.setAttribute(
            "aria-label",
            translate("فتح القائمة", "Open menu"),
        );

        document.body.classList.remove("menu-open");

        closeDropdowns();
    }

    mobileToggle?.addEventListener("click", () => {
        if (!mainNav) return;

        const isOpen = mainNav.classList.toggle("is-open");

        mobileToggle.classList.toggle("is-active", isOpen);
        mobileToggle.setAttribute("aria-expanded", String(isOpen));

        mobileToggle.setAttribute(
            "aria-label",
            isOpen
                ? translate("إغلاق القائمة", "Close menu")
                : translate("فتح القائمة", "Open menu"),
        );

        document.body.classList.toggle("menu-open", isOpen);

        if (!isOpen) closeDropdowns();
    });

    document.addEventListener("click", (event) => {
        if (!event.target.closest(".nav-dropdown")) {
            closeDropdowns();
        }

        if (
            searchPanel &&
            !event.target.closest(".search-panel") &&
            !event.target.closest(".search-toggle")
        ) {
            searchPanel.classList.remove("is-visible");
        }

        if (
            mainNav &&
            mobileToggle &&
            window.innerWidth < 1200 &&
            mainNav.classList.contains("is-open") &&
            !event.target.closest(".main-nav") &&
            !event.target.closest(".mobile-toggle")
        ) {
            closeMobileMenu();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeDropdowns();
            closeMobileMenu();
            searchPanel?.classList.remove("is-visible");
        }
    });

    window.addEventListener("resize", () => {
        if (window.innerWidth >= 1200) {
            closeMobileMenu();
        }
    });

    // Search Panel

    if (searchToggle && searchPanel) {
        searchToggle.addEventListener("click", (event) => {
            event.stopPropagation();

            const isVisible = searchPanel.classList.toggle("is-visible");

            if (isVisible) {
                searchInput?.focus();
            }
        });

        searchPanel.addEventListener("click", (event) => {
            event.stopPropagation();
        });
    }

    if (searchPanel && searchInput) {
        searchPanel.addEventListener("submit", (event) => {
            event.preventDefault();

            const query = searchInput.value.trim().toLocaleLowerCase();

            if (!query) {
                searchInput.focus();
                return;
            }

            const items = $$(".service-card, .mega-menu-content a");

            const match = items.find((item) =>
                item.textContent.toLocaleLowerCase().includes(query),
            );

            if (!match) {
                searchInput.setCustomValidity(
                    translate(
                        "لم يتم العثور على الخدمة المطلوبة",
                        "The requested service was not found",
                    ),
                );

                searchInput.reportValidity();
                searchInput.setCustomValidity("");

                return;
            }

            searchPanel.classList.remove("is-visible");

            const parentDropdown = match.closest(".nav-dropdown");

            if (parentDropdown) {
                let current = parentDropdown;

                while (current && mainNav?.contains(current)) {
                    setDropdownOpen(current, true);

                    current = current.parentElement?.closest(".nav-dropdown");
                }
            }

            match.scrollIntoView({
                behavior: "smooth",
                block: "center",
            });

            if (typeof match.animate === "function") {
                match.animate(
                    [
                        { outline: "0 solid rgba(233,184,111,0)" },
                        { outline: "3px solid rgba(233,184,111,.8)" },
                        { outline: "0 solid rgba(233,184,111,0)" },
                    ],
                    {
                        duration: 1200,
                        easing: "ease-out",
                    },
                );
            }
        });
    }

    // Hero Slider

    const sliderThumbs = document.querySelectorAll(".slider-thumb");

    function showSlide(index) {
        if (!heroSlides.length) return;

        currentSlide = (index + heroSlides.length) % heroSlides.length;

        heroSlides.forEach((slide, i) => {
            const active = i === currentSlide;

            slide.classList.toggle("active", active);
            slide.setAttribute("aria-hidden", String(!active));
        });

        heroDots.forEach((dot, i) => {
            const active = i === currentSlide;

            dot.classList.toggle("active", active);

            dot.setAttribute("aria-current", active ? "true" : "false");
        });

        sliderThumbs.forEach((thumb, i) => {
            const active = i === currentSlide;

            thumb.classList.toggle("active", active);
            thumb.setAttribute("aria-current", active ? "true" : "false");
        });

        if (currentSlideNumber) {
            currentSlideNumber.textContent = String(currentSlide + 1).padStart(
                2,
                "0",
            );
        }

        if (slideProgress) {
            slideProgress.style.width = `${((currentSlide + 1) / heroSlides.length) * 100}%`;
        }
    }

    function stopHeroTimer() {
        if (heroTimer !== null) {
            clearInterval(heroTimer);
            heroTimer = null;
        }
    }

    function startHeroTimer() {
        stopHeroTimer();

        if (heroSlides.length <= 1) return;

        heroTimer = setInterval(() => {
            showSlide(currentSlide + 1);
        }, heroInterval);
    }

    function goToSlide(index) {
        showSlide(index);
        startHeroTimer();
    }

    prevButton?.addEventListener("click", () => {
        goToSlide(currentSlide - 1);
    });

    nextButton?.addEventListener("click", () => {
        goToSlide(currentSlide + 1);
    });

    heroDots.forEach((dot, index) => {
        dot.addEventListener("click", () => {
            goToSlide(index);
        });
    });

    sliderThumbs.forEach((thumb, index) => {
        thumb.addEventListener("click", () => {
            const targetIndex = Number(thumb.dataset.slide ?? index);
            goToSlide(targetIndex);
        });
    });

    if (hero) {
        hero.addEventListener(
            "touchstart",
            (event) => {
                touchStartX = event.changedTouches[0].screenX;
            },
            { passive: true },
        );

        hero.addEventListener(
            "touchend",
            (event) => {
                const difference =
                    touchStartX - event.changedTouches[0].screenX;

                if (Math.abs(difference) > 60) {
                    goToSlide(currentSlide + (difference > 0 ? 1 : -1));
                }
            },
            { passive: true },
        );
    }

    if (heroSlides.length) {
        showSlide(0);
        startHeroTimer();
    }

    // =====================================================
    // Products Page
    // الفلترة والبحث والترتيب والـ pagination كلها من السيرفر (Laravel)
    // هنا فقط: عرض grid/list + فتح/قفل القوائم + زر الفلتر في الموبايل
    // =====================================================

    // تبديل العرض grid / list
    $$(".products-view-buttons button").forEach((button) => {
        button.addEventListener("click", () => {
            $$(".products-view-buttons button").forEach((item) => {
                item.classList.toggle("active", item === button);
            });

            $(".products-grid")?.classList.toggle(
                "list-view",
                button.dataset.view === "list",
            );
        });
    });

    // فتح/قفل السايد بار في الموبايل
    $("#productsFilterToggle")?.addEventListener("click", () => {
        const sidebar = $("#productsSidebar");

        if (!sidebar) return;

        const isOpen = sidebar.classList.toggle("mobile-open");

        if (isOpen) {
            sidebar.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
        }
    });

    $("#productsMobileToggle")?.addEventListener("click", () => {
        $(".products-header-nav")?.classList.toggle("active");
    });

    // قائمة الأقسام في السايد بار
    const productsCategories = document.getElementById("productsCategories");

    if (productsCategories) {
        // الـ CSS محتاج الـ wrapper ده لعرض محتوى القائمة الفرعية
        productsCategories
            .querySelectorAll(".products-category-submenu")
            .forEach((submenu) => {
                if (submenu.querySelector(".products-category-submenu-inner")) {
                    return;
                }

                const inner = document.createElement("div");
                inner.className = "products-category-submenu-inner";

                while (submenu.firstChild) {
                    inner.appendChild(submenu.firstChild);
                }

                submenu.appendChild(inner);
            });

        // فتح وقفل القوائم فقط. الروابط تشتغل عادي من السيرفر
        productsCategories.addEventListener("click", (event) => {
            const trigger = event.target.closest(".products-category-trigger");

            if (!trigger) return;

            const dropdown = trigger.closest(".products-category-dropdown");

            if (!dropdown) return;

            const shouldOpen = !dropdown.classList.contains("is-open");

            productsCategories
                .querySelectorAll(".products-category-dropdown.is-open")
                .forEach((item) => {
                    if (item !== dropdown) {
                        item.classList.remove("is-open");

                        item.querySelector(
                            ".products-category-trigger",
                        )?.setAttribute("aria-expanded", "false");
                    }
                });

            dropdown.classList.toggle("is-open", shouldOpen);
            trigger.setAttribute("aria-expanded", String(shouldOpen));
        });
    }

    // Contact Form

    const contactForm = $("#contactForm");
    const contactFormStatus = $("#contactFormStatus");

    const contactServiceTranslations = {
        "تصميم وطباعة الهويات البصرية": "Visual Identity Design & Printing",
        "البنرات والملصقات": "Banners & Stickers",
        "اللوحات الإعلانية والكلادينج": "Advertising Signs & Cladding",
        "الدروع والهدايا": "Awards & Promotional Gifts",
        "القص والحفر بالليزر": "Laser Cutting & Engraving",
        "خدمات الحج والعمرة": "Hajj & Umrah Services",
        "خدمة أخرى": "Other Service",
    };

    if (contactForm && !contactForm.dataset.whatsappBound) {
        contactForm.dataset.whatsappBound = "true";

        contactForm.addEventListener("submit", (event) => {
            event.preventDefault();

            if (!contactForm.reportValidity()) return;

            const name = $("#contactName")?.value.trim() || "";
            const phone = $("#contactPhone")?.value.trim() || "";
            const service = $("#contactService")?.value || "";
            const details = $("#contactMessage")?.value.trim() || "";

            const serviceLabel = isEnglish()
                ? contactServiceTranslations[service] || service
                : service;

            const message = isEnglish()
                ? [
                      "Hello Al Fannan Advertising 👋",
                      "",
                      "I would like to request a service:",
                      "",
                      `Name: ${name}`,
                      `Mobile: ${phone}`,
                      `Service: ${serviceLabel}`,
                      "",
                      "Request Details:",
                      details,
                  ].join("\n")
                : [
                      "السلام عليكم، أريد التواصل مع شركة الفنان للدعاية والإعلان.",
                      "",
                      `الاسم: ${name}`,
                      `رقم الجوال: ${phone}`,
                      `الخدمة المطلوبة: ${serviceLabel}`,
                      "",
                      "تفاصيل الطلب:",
                      details,
                  ].join("\n");

            const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

            const whatsappWindow = window.open(whatsappUrl, "_blank");

            if (whatsappWindow) {
                whatsappWindow.opener = null;
                contactForm.reset();

                if (contactFormStatus) {
                    contactFormStatus.textContent = translate(
                        "تم فتح واتساب وتجهيز رسالتك. اضغط إرسال داخل واتساب لإتمام العملية.",
                        "WhatsApp is open. Please press Send to complete your request.",
                    );
                }
            } else if (contactFormStatus) {
                contactFormStatus.textContent = translate(
                    "يرجى السماح بالنوافذ المنبثقة لفتح واتساب، ثم المحاولة مرة أخرى.",
                    "Please allow pop-ups to open WhatsApp, then try again.",
                );
            }
        });
    }

    // WhatsApp Buttons

    function updateCustomWhatsapp() {
        const whatsappButton = $("#alfSvCustomWhatsapp");

        if (!whatsappButton) return;

        const message = translate(
            "مرحباً، أرغب في طلب خدمة مخصصة",
            "Hello, I would like to request a custom service.",
        );

        whatsappButton.href = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

        whatsappButton.target = "_blank";
        whatsappButton.rel = "noopener noreferrer";
    }

    function updateProductWhatsappButtons() {
        const helpButton = $("#productsHelpWhatsapp");
        const quoteButton = $("#productsQuoteWhatsapp");

        if (helpButton) {
            const message = translate(
                "مرحباً، أرغب في طلب تصميم خاص",
                "Hello, I would like to request a custom design.",
            );

            helpButton.href = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

            helpButton.target = "_blank";
            helpButton.rel = "noopener noreferrer";
        }

        if (quoteButton) {
            const message = translate(
                "مرحباً، أرغب في طلب عرض سعر للمنتجات",
                "Hello, I would like to request a quotation for your products.",
            );

            quoteButton.href = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

            quoteButton.target = "_blank";
            quoteButton.rel = "noopener noreferrer";
        }
    }

    function updateProductAriaLabels() {
        const searchField = $("#sidebarSearch");

        if (searchField) {
            searchField.setAttribute(
                "aria-label",
                translate("البحث عن منتج", "Search Products"),
            );

            searchField.placeholder = translate(
                "ابحث عن منتج...",
                "Search for a product...",
            );
        }

        const gridButton = $('.products-view-buttons button[data-view="grid"]');

        const listButton = $('.products-view-buttons button[data-view="list"]');

        if (gridButton) {
            gridButton.setAttribute(
                "aria-label",
                translate("عرض شبكي", "Grid View"),
            );
        }

        if (listButton) {
            listButton.setAttribute(
                "aria-label",
                translate("عرض قائمة", "List View"),
            );
        }
    }

    // Services Results

    function updateServicesResults() {
        const servicesGrid = $("#alfSvGrid");
        const resultsText = $("#alfSvResultsText");
        const totalElement = $("#alfSvTotal");

        if (!servicesGrid || !resultsText) return;

        const items = $$(".alf-sv-item", servicesGrid);

        const visibleCount = items.filter(
            (item) => !item.hidden && getComputedStyle(item).display !== "none",
        ).length;

        resultsText.textContent = translate(
            `يتم عرض ${visibleCount} خدمات`,
            `Showing ${visibleCount} Services`,
        );

        if (totalElement) {
            totalElement.textContent = items.length;
        }
    }

    // Footer Year

    ["#productsYear", "#currentYear", "#alfFooterYear"].forEach((selector) => {
        const element = $(selector);

        if (element) {
            element.textContent = new Date().getFullYear();
        }
    });

    // Back To Top

    const backToTop = $("#backToTop");

    if (backToTop) {
        const toggleBackToTop = () => {
            backToTop.classList.toggle("show", window.scrollY > 300);
        };

        window.addEventListener("scroll", toggleBackToTop, { passive: true });

        toggleBackToTop();

        backToTop.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }

    // Language Direction

    function updateDirections() {
        const direction = isEnglish() ? "ltr" : "rtl";

        document
            .querySelectorAll(
                ".alf-vm-section, .alf-services-section, .alf-why-section, .contact-section, .alf-footer, .alf-sv-hero, .alf-sv-services, .alf-sv-custom, .products-hero, .products-page",
            )
            .forEach((section) => {
                section.setAttribute("dir", direction);
            });
    }

    function updateLanguage() {
        updateDirections();
        updateCustomWhatsapp();
        updateProductWhatsappButtons();
        updateProductAriaLabels();
        updateServicesResults();

        if (mobileToggle) {
            const isOpen = mainNav?.classList.contains("is-open");

            mobileToggle.setAttribute(
                "aria-label",
                isOpen
                    ? translate("إغلاق القائمة", "Close menu")
                    : translate("فتح القائمة", "Open menu"),
            );
        }
    }

    function handleLanguageChanged() {
        lastObservedLanguage = getLang();

        renderMegaMenu();
        updateLanguage();
        updateLanguageSwitcher();
    }

    document.addEventListener("languageChanged", handleLanguageChanged);

    const languageObserver = new MutationObserver(() => {
        const lang = getLang();

        if (lang === lastObservedLanguage) return;

        lastObservedLanguage = lang;

        translatePage();
        renderMegaMenu();
        updateLanguage();
        updateLanguageSwitcher();
    });

    languageObserver.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ["lang"],
    });

    // Initial Page Setup

    translatePage();
    renderMegaMenu();
    updateLanguage();
    updateLanguageSwitcher();

    if (typeof AOS !== "undefined") {
        AOS.init({
            duration: 850,
            easing: "ease-out-cubic",
            once: true,
            offset: 80,
        });
    }

    // Testimonials Slider

    const slider = document.querySelector(".alf-testimonials-slider");
    const track = document.getElementById("alfTestimonialsTrack");
    const dotsContainer = document.querySelector(".alf-testimonials-dots");
    const prevBtn = document.querySelector(".alf-testimonials-prev");
    const nextBtn = document.querySelector(".alf-testimonials-next");

    if (slider && track) {
        let currentIndex = 0;
        let autoPlay = null;
        let startX = 0;
        let endX = 0;

        const getCards = () => [
            ...track.querySelectorAll(".alf-testimonial-card"),
        ];

        function getMetrics() {
            const cards = getCards();

            if (!cards.length) {
                return { maxIndex: 0, step: 0 };
            }

            const cardWidth = cards[0].getBoundingClientRect().width;
            const gap = parseFloat(getComputedStyle(track).gap) || 0;
            const sliderWidth = slider.clientWidth;

            const visibleCards = Math.max(
                1,
                Math.floor((sliderWidth + gap) / (cardWidth + gap)),
            );

            return {
                maxIndex: Math.max(0, cards.length - visibleCards),
                step: cardWidth + gap,
            };
        }

        function updateDots() {
            if (!dotsContainer) return;

            const { maxIndex } = getMetrics();

            dotsContainer.innerHTML = "";

            for (let i = 0; i <= maxIndex; i++) {
                const dot = document.createElement("button");

                dot.type = "button";
                dot.setAttribute("aria-label", `Slide ${i + 1}`);

                dot.addEventListener("click", function () {
                    currentIndex = i;
                    updateSlider();
                    restartAutoPlay();
                });

                dotsContainer.appendChild(dot);
            }
        }

        function updateSlider() {
            const { maxIndex, step } = getMetrics();

            currentIndex = Math.max(0, Math.min(currentIndex, maxIndex));

            const offset = currentIndex * step;

            track.style.transform = `translate3d(${-offset}px, 0, 0)`;

            if (dotsContainer) {
                [...dotsContainer.children].forEach((dot, index) => {
                    dot.classList.toggle("active", index === currentIndex);
                });
            }

            if (prevBtn) {
                prevBtn.disabled = currentIndex === 0;
            }

            if (nextBtn) {
                nextBtn.disabled = currentIndex === maxIndex;
            }
        }

        function goNext() {
            const { maxIndex } = getMetrics();

            currentIndex = currentIndex >= maxIndex ? 0 : currentIndex + 1;

            updateSlider();
        }

        function goPrev() {
            const { maxIndex } = getMetrics();

            currentIndex = currentIndex <= 0 ? maxIndex : currentIndex - 1;

            updateSlider();
        }

        function restartAutoPlay() {
            clearInterval(autoPlay);
            autoPlay = setInterval(goNext, 4500);
        }

        if (nextBtn) {
            nextBtn.addEventListener("click", function () {
                goNext();
                restartAutoPlay();
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener("click", function () {
                goPrev();
                restartAutoPlay();
            });
        }

        function refreshSlider() {
            currentIndex = 0;
            updateDots();
            updateSlider();
        }

        window.addEventListener("resize", refreshSlider);

        document.addEventListener("languageChanged", refreshSlider);

        track.addEventListener(
            "touchstart",
            function (event) {
                startX = event.changedTouches[0].screenX;
            },
            { passive: true },
        );

        track.addEventListener(
            "touchend",
            function (event) {
                endX = event.changedTouches[0].screenX;

                const difference = endX - startX;

                if (Math.abs(difference) < 50) return;

                const isRTL = document.documentElement.dir === "rtl";

                if (isRTL) {
                    difference > 0 ? goNext() : goPrev();
                } else {
                    difference < 0 ? goNext() : goPrev();
                }

                restartAutoPlay();
            },
            { passive: true },
        );

        slider.addEventListener("mouseenter", function () {
            clearInterval(autoPlay);
        });

        slider.addEventListener("mouseleave", restartAutoPlay);

        refreshSlider();
        restartAutoPlay();
    }

    // Package Buttons

    document.addEventListener("click", function (event) {
        const button = event.target.closest(".alf-package-btn");

        if (!button) return;

        event.preventDefault();

        const packageKey = button.dataset.package;
        const price = button.dataset.price;

        const currentLang = getLang();

        const packageNames = {
            ar: {
                launch: "باقة الانطلاقة",
                identity: "باقة الهوية الذهبية",
                business: "باقة المؤسسات",
                events: "باقة المناسبات",
            },
            en: {
                launch: "Launch Package",
                identity: "Golden Identity Package",
                business: "Business Package",
                events: "Events Package",
            },
        };

        const packageName = packageNames[currentLang][packageKey];

        if (!packageName || !price) return;

        const message =
            currentLang === "en"
                ? `Hello Al Fannan, I would like to order:\nPackage: ${packageName}\nPrice: SAR ${Number(price).toLocaleString("en-US")}`
                : `مرحباً شركة الفنان، أرغب في طلب الباقة التالية:\nالباقة: ${packageName}\nالسعر: ${Number(price).toLocaleString("ar-EG")} ر.س`;

        const whatsappURL = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

        window.open(whatsappURL, "_blank", "noopener,noreferrer");
    });

    // Theme Toggle

    const themeToggle = document.getElementById("themeToggle");

    if (themeToggle) {
        const savedTheme = localStorage.getItem("alfTheme");

        const applyTheme = (isDark) => {
            document.documentElement.classList.toggle("dark-theme", isDark);

            themeToggle.innerHTML = isDark
                ? '<i class="fas fa-sun"></i>'
                : '<i class="fas fa-moon"></i>';

            themeToggle.setAttribute(
                "aria-label",
                isDark ? "Switch to light theme" : "Switch to dark theme",
            );

            themeToggle.setAttribute("aria-pressed", String(isDark));
        };

        applyTheme(savedTheme === "dark");

        themeToggle.addEventListener("click", () => {
            const isDark =
                !document.documentElement.classList.contains("dark-theme");

            applyTheme(isDark);

            localStorage.setItem("alfTheme", isDark ? "dark" : "light");
        });
    }
});

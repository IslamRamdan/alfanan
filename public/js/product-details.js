
document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const whatsappNumber = "966545953908";

    const $ = (selector, parent = document) =>
        parent.querySelector(selector);

    const $$ = (selector, parent = document) =>
        [...parent.querySelectorAll(selector)];

    const getLang = () =>
        document.documentElement.lang.toLowerCase().startsWith("en")
            ? "en"
            : "ar";

    const isEnglish = () => getLang() === "en";

    function getElementText(selector) {
        return $(selector)?.textContent.trim() || "";
    }

    function getLocalizedText(element) {
        if (!element) return "";

        return element.dataset[isEnglish() ? "en" : "ar"] ||
            element.textContent.trim();
    }

    function setText(selector, value) {
        const element = $(selector);

        if (element) {
            element.textContent = value;
        }
    }

    function formatPrice(value) {
        return Number(value || 0).toLocaleString("en-US", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function getCurrency() {
        return isEnglish() ? "SAR" : "ر.س";
    }

    function getProductImageUrl(path) {
        if (!path) return "";

        try {
            return new URL(path, window.location.href).href;
        } catch {
            return path;
        }
    }

    /* Mobile Navigation */

    const menuToggle = $("#alfDetailMenuToggle");
    const nav = $("#alfDetailNav");

    if (menuToggle && nav) {
        menuToggle.addEventListener("click", () => {
            const isOpen = nav.classList.toggle("active");

            menuToggle.setAttribute(
                "aria-expanded",
                String(isOpen)
            );

            const icon = $("i", menuToggle);

            if (icon) {
                icon.className = isOpen
                    ? "fas fa-xmark"
                    : "fas fa-bars";
            }
        });

        $$("a", nav).forEach(link => {
            link.addEventListener("click", () => {
                nav.classList.remove("active");

                menuToggle.setAttribute(
                    "aria-expanded",
                    "false"
                );

                const icon = $("i", menuToggle);

                if (icon) {
                    icon.className = "fas fa-bars";
                }
            });
        });
    }

    /* Current Year */

    setText("#alfDetailYear", new Date().getFullYear());

    /* Product Gallery */

    const mainImage = $("#alfDetailMainImage");
    const thumbnails = $$("#alfDetailThumbnails .alf-detail-thumbnail");
    const lightboxElement = $("#alfDetailLightbox");
    const lightboxImage = $("#alfDetailLightboxImage");

    let activeImageIndex = 0;
    let touchStartX = 0;

    const images = thumbnails
        .map(button => {
            const image = $("img", button);
            return image?.getAttribute("src") || "";
        })
        .filter(Boolean);

    if (!images.length && mainImage?.getAttribute("src")) {
        images.push(mainImage.getAttribute("src"));
    }

    function getImageAlt(index) {
        const productName = getLocalizedText(
            $(".alf-detail-title")
        );

        const imageLabel = isEnglish() ? "Image" : "صورة";

        return `${productName} - ${imageLabel} ${index + 1}`;
    }

    function updateLightboxImage() {
        if (!lightboxImage || !images.length) return;

        lightboxImage.src = images[activeImageIndex];
        lightboxImage.alt = getImageAlt(activeImageIndex);
    }

    function showImage(index) {
        if (!images.length) return;

        activeImageIndex =
            ((index % images.length) + images.length) %
            images.length;

        const imageUrl = images[activeImageIndex];

        if (mainImage) {
            mainImage.src = imageUrl;
            mainImage.alt = getImageAlt(activeImageIndex);
        }

        setText(
            "#alfDetailCurrentImage",
            String(activeImageIndex + 1).padStart(2, "0")
        );

        setText(
            "#alfDetailTotalImages",
            String(images.length).padStart(2, "0")
        );

        thumbnails.forEach((button, index) => {
            const isActive = index === activeImageIndex;

            button.classList.toggle("active", isActive);

            button.setAttribute(
                "aria-pressed",
                String(isActive)
            );
        });

        if (lightboxElement?.classList.contains("show")) {
            updateLightboxImage();
        }
    }

    function nextImage() {
        showImage(activeImageIndex + 1);
    }

    function previousImage() {
        showImage(activeImageIndex - 1);
    }

    thumbnails.forEach((button, index) => {
        button.addEventListener("click", () => {
            showImage(index);
        });

        button.setAttribute(
            "aria-pressed",
            String(index === 0)
        );
    });

    $("#alfDetailPrev")?.addEventListener(
        "click",
        previousImage
    );

    $("#alfDetailNext")?.addEventListener(
        "click",
        nextImage
    );

    showImage(0);

    /* Image Zoom */

    $("#alfDetailZoom")?.addEventListener("click", () => {
        if (!images.length) return;

        if (
            lightboxElement &&
            lightboxImage &&
            typeof bootstrap !== "undefined"
        ) {
            updateLightboxImage();

            bootstrap.Modal
                .getOrCreateInstance(lightboxElement)
                .show();

            return;
        }

        window.open(
            getProductImageUrl(images[activeImageIndex]),
            "_blank",
            "noopener,noreferrer"
        );
    });

    /* Touch Swipe */

    mainImage?.addEventListener(
        "touchstart",
        event => {
            touchStartX = event.changedTouches[0].screenX;
        },
        { passive: true }
    );

    mainImage?.addEventListener(
        "touchend",
        event => {
            const difference =
                touchStartX - event.changedTouches[0].screenX;

            if (Math.abs(difference) < 50) return;

            if (difference > 0) {
                nextImage();
            } else {
                previousImage();
            }
        },
        { passive: true }
    );

    /* Keyboard Gallery Navigation */

    document.addEventListener("keydown", event => {
        const target = event.target;

        if (
            target instanceof HTMLElement &&
            target.closest(
                "input, textarea, select, [contenteditable='true']"
            )
        ) {
            return;
        }

        if (event.key === "ArrowRight") {
            isEnglish()
                ? nextImage()
                : previousImage();
        }

        if (event.key === "ArrowLeft") {
            isEnglish()
                ? previousImage()
                : nextImage();
        }
    });

    /* Product Tabs */

    const tabButtons = $$(".alf-detail-tabs button");
    const tabPanels = $$(".alf-detail-tab-content");

    tabButtons.forEach(button => {
        button.addEventListener("click", () => {
            const tab = button.dataset.tab;

            tabButtons.forEach(item => {
                const isActive = item === button;

                item.classList.toggle("active", isActive);

                item.setAttribute(
                    "aria-selected",
                    String(isActive)
                );
            });

            tabPanels.forEach(panel => {
                panel.classList.toggle(
                    "active",
                    panel.id === `alfTab-${tab}`
                );
            });
        });
    });

    /* WhatsApp Order */

    const notesInput = $("#alfDetailNotes");
    const whatsappButton = $("#alfDetailWhatsapp");

    function buildWhatsappMessage() {
        const productName = getLocalizedText(
            $(".alf-detail-title")
        );

        const category = getLocalizedText(
            $(".alf-detail-category")
        );

        const sku = getElementText(".alf-detail-code")
            .replace(/^SKU:\s*/i, "");

        const price = getElementText("#alfDetailPrice")
            .replace(/\s+/g, " ")
            .trim();

        const notes = notesInput?.value.trim() || "";

        const imageUrl = getProductImageUrl(
            images[activeImageIndex] || mainImage?.getAttribute("src")
        );

        const english = isEnglish();

        const labels = english
            ? {
                greeting: "Hello Al Fannan Advertising 👋",
                intro: "I would like to order the following product:",
                name: "Product Name",
                sku: "Product Number",
                category: "Category",
                price: "Listed Price",
                notes: "Additional Notes",
                image: "Product Image",
                confirm: "Please confirm the final product price.",
                delivery: "Please confirm availability and production time.",
                thanks: "Thank you."
            }
            : {
                greeting: "مرحباً شركة الفنان للدعاية والإعلان 👋",
                intro: "أرغب في طلب المنتج التالي:",
                name: "اسم المنتج",
                sku: "رقم المنتج",
                category: "القسم",
                price: "السعر المعروض",
                notes: "ملاحظات إضافية",
                image: "صورة المنتج",
                confirm: "أرجو تأكيد السعر النهائي للمنتج.",
                delivery: "وأرجو توضيح مدة التنفيذ والتوفر.",
                thanks: "شكراً لكم."
            };

        const lines = [
            labels.greeting,
            "",
            labels.intro,
            "",
            `📦 ${labels.name}: ${productName}`,
            `🏷️ ${labels.sku}: ${sku}`,
            `📂 ${labels.category}: ${category}`,
            `💰 ${labels.price}: ${price}`,
            notes ? "" : null,
            notes ? `📝 ${labels.notes}:\n${notes}` : null,
            imageUrl ? "" : null,
            imageUrl ? `🖼️ ${labels.image}: ${imageUrl}` : null,
            "",
            labels.confirm,
            labels.delivery,
            "",
            labels.thanks
        ];

        return lines
            .filter(line => line !== null)
            .join("\n");
    }

    whatsappButton?.addEventListener("click", event => {
        event.preventDefault();

        const message = buildWhatsappMessage();

        const url =
            `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

        window.open(
            url,
            "_blank",
            "noopener,noreferrer"
        );
    });

    /* Accessibility Labels */

    function updateAccessibleLabels() {
        const english = isEnglish();

        const labels = [
            [
                "#alfDetailZoom",
                english ? "Zoom Image" : "تكبير الصورة"
            ],
            [
                "#alfDetailPrev",
                english ? "Previous Image" : "الصورة السابقة"
            ],
            [
                "#alfDetailNext",
                english ? "Next Image" : "الصورة التالية"
            ]
        ];

        labels.forEach(([selector, label]) => {
            const element = $(selector);

            if (!element) return;

            element.setAttribute("aria-label", label);
            element.setAttribute("title", label);
        });
    }

    /* Language Changes */

    function refreshGalleryLanguage() {
        if (!mainImage) return;

        mainImage.alt = getImageAlt(activeImageIndex);

        thumbnails.forEach((button, index) => {
            const image = $("img", button);

            if (image) {
                image.alt = getImageAlt(index);
            }
        });

        updateAccessibleLabels();
    }

    function handleLanguageChanged() {
        refreshGalleryLanguage();
    }

    window.addEventListener(
        "languageChanged",
        handleLanguageChanged
    );

    document.addEventListener(
        "languageChanged",
        handleLanguageChanged
    );

    const languageObserver = new MutationObserver(() => {
        refreshGalleryLanguage();
    });

    languageObserver.observe(
        document.documentElement,
        {
            attributes: true,
            attributeFilter: ["lang"]
        }
    );

    refreshGalleryLanguage();

});

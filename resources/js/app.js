import './bootstrap'
import '../css/app.css'

/*
|--------------------------------------------------------------------------
| Preloader
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", function () {
    const preloader = document.getElementById("preloader");

    if (!preloader) return;

    setTimeout(() => {
        preloader.style.opacity = "0";
        preloader.style.transition = "opacity 500ms ease";

        setTimeout(() => {
            preloader.remove();
        }, 500);

    }, 400);
});

/*
|--------------------------------------------------------------------------
| Mobile Drawer Navigation
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", function () {
    const openBtn = document.getElementById("mobile-menu-open");
    const closeBtn = document.getElementById("mobile-menu-close");
    const drawer = document.getElementById("mobile-menu-drawer");
    const overlay = document.getElementById("mobile-menu-overlay");
    const projectsToggle = document.getElementById("mobile-projects-toggle");
    const projectsSubmenu = document.getElementById("mobile-projects-submenu");
    const projectsChevron = document.getElementById("mobile-projects-chevron");

    if (!openBtn || !closeBtn || !drawer || !overlay) return;

    const openMenu = () => {
        drawer.classList.remove("translate-x-full");
        overlay.classList.remove("hidden");
        document.body.classList.add("overflow-hidden");
    };

    const closeMenu = () => {
        drawer.classList.add("translate-x-full");
        overlay.classList.add("hidden");
        document.body.classList.remove("overflow-hidden");
    };

    openBtn.addEventListener("click", openMenu);
    closeBtn.addEventListener("click", closeMenu);
    overlay.addEventListener("click", closeMenu);

    if (projectsToggle && projectsSubmenu) {
        projectsToggle.addEventListener("click", () => {
            const isHidden = projectsSubmenu.classList.contains("hidden");
            projectsSubmenu.classList.toggle("hidden");
            projectsToggle.setAttribute("aria-expanded", isHidden ? "true" : "false");

            if (projectsChevron) {
                projectsChevron.classList.toggle("rotate-180", isHidden);
            }
        });
    }

    drawer.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", closeMenu);
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeMenu();
    });
});

/*
|--------------------------------------------------------------------------
| Home Featured Projects Slider
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", function () {
    const slider = document.getElementById("home-featured-slider");
    if (!slider) return;

    const slides = Array.from(slider.querySelectorAll("[data-slide]"));
    const dots = Array.from(slider.querySelectorAll("[data-slide-dot]"));
    const prevBtn = document.getElementById("home-featured-prev");
    const nextBtn = document.getElementById("home-featured-next");

    if (slides.length <= 1) return;

    let index = 0;
    let intervalId = null;

    const render = () => {
        slides.forEach((slide, i) => {
            slide.classList.toggle("hidden", i !== index);
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle("bg-white", i === index);
            dot.classList.toggle("bg-white/30", i !== index);
        });
    };

    const goTo = (target) => {
        index = (target + slides.length) % slides.length;
        render();
    };

    const startAuto = () => {
        intervalId = setInterval(() => goTo(index + 1), 5000);
    };

    const resetAuto = () => {
        if (intervalId) clearInterval(intervalId);
        startAuto();
    };

    prevBtn?.addEventListener("click", () => {
        goTo(index - 1);
        resetAuto();
    });

    nextBtn?.addEventListener("click", () => {
        goTo(index + 1);
        resetAuto();
    });

    dots.forEach((dot, i) => {
        dot.addEventListener("click", () => {
            goTo(i);
            resetAuto();
        });
    });

    render();
    startAuto();
});


/*
|--------------------------------------------------------------------------
| Page Fade Transition
|--------------------------------------------------------------------------
*/

document.addEventListener("click", function (e) {

    const link = e.target.closest("a");

    if (!link) return;

    const href = link.getAttribute("href");

    if (!href || href.startsWith("#") || link.target === "_blank") return;

    if (
        href.startsWith("mailto:") ||
        href.startsWith("tel:") ||
        e.ctrlKey || e.metaKey
    ) return;

    e.preventDefault();

    const overlay = document.getElementById("page-transition");

    if (!overlay) {
        window.location.href = href;
        return;
    }

    overlay.style.opacity = "1";
    overlay.style.pointerEvents = "auto";

    setTimeout(() => {
        window.location.href = href;
    }, 250);

});

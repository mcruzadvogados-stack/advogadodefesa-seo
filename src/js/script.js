'use strict';

// ── Menu mobile ───────────────────────────────────────────────────
function openMobileMenu(menu) {
    menu.classList.toggle('opened');
    document.getElementById('header').classList.toggle('opened');
}

function closeMobileMenu() {
    document.getElementById('mobile_menu').classList.remove('opened');
    document.getElementById('header').classList.remove('opened');
}

// ── Header sticky ao rolar ────────────────────────────────────────
const STICKY_SCROLL_THRESHOLD = 400;

window.addEventListener('scroll', () => {
    const header = document.getElementById('header');
    if (!header) return;
    header.classList.toggle('sticky', window.scrollY >= STICKY_SCROLL_THRESHOLD);
}, { passive: true });

// ── Proteção de conteúdo ──────────────────────────────────────────
document.addEventListener('contextmenu', e => e.preventDefault());
document.addEventListener('dragstart',   e => e.preventDefault());
document.addEventListener('selectstart', e => e.preventDefault());

// ── Ocultar seções em mobile (≤768px) ────────────────────────────
const MOBILE_BREAKPOINT    = 768;
const MOBILE_HIDDEN_SELECTORS = [
    '#section_contatos',
    '.banner',
    '#section_diferenciais',
    '.banner_depoimentos'
];

function applyMobileVisibility() {
    const isMobile = window.innerWidth <= MOBILE_BREAKPOINT;
    MOBILE_HIDDEN_SELECTORS.forEach(selector => {
        const el = document.querySelector(selector);
        if (!el) return;
        if (isMobile) {
            el.style.setProperty('display', 'none', 'important');
        } else {
            el.style.removeProperty('display');
        }
    });
}

applyMobileVisibility();
window.addEventListener('resize', applyMobileVisibility, { passive: true });

// ── Animação de contadores ────────────────────────────────────────
(function initCounterAnimations() {
    const PHASE_1_DURATION_MS = 5000;
    const PHASE_2_INTERVAL_MS = 1000;

    function formatNumber(value, prefix, suffix) {
        return prefix + Math.round(value).toLocaleString('pt-BR') + suffix;
    }

    function animateCounter(el) {
        const target  = +el.dataset.target;
        const prefix  = el.dataset.prefix || '';
        const suffix  = el.dataset.suffix || '';
        const phase1End = target - 5;

        let startTime = null;

        function runPhase1(timestamp) {
            if (!startTime) startTime = timestamp;
            const progress = Math.min((timestamp - startTime) / PHASE_1_DURATION_MS, 1);
            el.textContent = formatNumber(progress * phase1End, prefix, suffix);
            if (progress < 1) {
                requestAnimationFrame(runPhase1);
            } else {
                runPhase2(Math.round(phase1End));
            }
        }

        function runPhase2(current) {
            let value = current;
            const timer = setInterval(() => {
                value++;
                el.textContent = formatNumber(value, prefix, suffix);
                if (value >= target) clearInterval(timer);
            }, PHASE_2_INTERVAL_MS);
        }

        requestAnimationFrame(runPhase1);
    }

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.4 });

    document.querySelectorAll('.counter').forEach(el => observer.observe(el));
})();

// ── Vídeo hero — orientação responsiva ───────────────────────────
function setHeroVideoOrientation() {
    const video = document.querySelector('.hero_bg_video');
    if (!video) return;
    const isPortrait = window.matchMedia('(orientation: portrait)').matches;
    const sources    = video.querySelectorAll('source');
    if (!sources.length) return;
    const currentSrc = sources[0].getAttribute('src') || '';
    const alreadySet = isPortrait
        ? currentSrc.includes('_vertical')
        : !currentSrc.includes('_vertical');
    if (alreadySet) return;
    const base = isPortrait ? './src/video/hero_vertical_v2' : './src/video/hero_v2';
    sources[0].setAttribute('src', base + '.webm');
    sources[1].setAttribute('src', base + '.mp4');
    video.load();
}

setHeroVideoOrientation();
window.matchMedia('(orientation: portrait)').addEventListener('change', setHeroVideoOrientation);

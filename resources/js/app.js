import Lenis from 'lenis';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { animate, inView } from 'motion';

gsap.registerPlugin(ScrollTrigger);

const reduceMotion = window.matchMedia(
    '(prefers-reduced-motion: reduce)'
).matches;

const canHover = window.matchMedia(
    '(hover: hover) and (pointer: fine)'
).matches;

/*
|--------------------------------------------------------------------------
| 1. LENIS — GLOBAL SMOOTH SCROLL
|--------------------------------------------------------------------------
*/

let lenis = null;

if (!reduceMotion) {
    // Hindari membuat instance Lenis lebih dari satu kali.
    if (window.kosHavenLenis) {
        lenis = window.kosHavenLenis;
    } else {
        lenis = new Lenis({
            duration: 1.15,
            smoothWheel: true,
            wheelMultiplier: 0.9,
            touchMultiplier: 1.15,
            autoRaf: false,
            syncTouch: false,
            orientation: 'vertical',
            gestureOrientation: 'vertical',
        });

        window.kosHavenLenis = lenis;

        lenis.on('scroll', ScrollTrigger.update);

        gsap.ticker.add((time) => {
            lenis.raf(time * 1000);
        });

        gsap.ticker.lagSmoothing(0);
    }
}

/*
|--------------------------------------------------------------------------
| 2. HEADING REVEAL — GSAP PER KATA
|--------------------------------------------------------------------------
*/

function setupWordReveal() {
    if (reduceMotion) return;

    const headings = document.querySelectorAll(
        '[data-reveal-words]'
    );

    headings.forEach((heading) => {
        if (heading.dataset.wordRevealInitialized === 'true') {
            return;
        }

        // Hindari merusak heading yang memiliki elemen HTML.
        if (heading.children.length > 0) return;

        const originalText = heading.textContent.trim();

        if (!originalText) return;

        heading.dataset.wordRevealInitialized = 'true';
        heading.setAttribute('aria-label', originalText);

        const words = originalText.split(/\s+/);
        const fragment = document.createDocumentFragment();

        words.forEach((word, index) => {
            const span = document.createElement('span');

            span.className = 'kh-motion-word';
            span.textContent = word;
            span.setAttribute('aria-hidden', 'true');

            fragment.appendChild(span);

            if (index < words.length - 1) {
                fragment.appendChild(
                    document.createTextNode(' ')
                );
            }
        });

        heading.replaceChildren(fragment);

        const wordElements = heading.querySelectorAll(
            '.kh-motion-word'
        );

        gsap.fromTo(
            wordElements,
            {
                opacity: 0,
                y: 24,
                rotateX: -35,
            },
            {
                opacity: 1,
                y: 0,
                rotateX: 0,
                duration: 0.75,
                stagger: 0.09,
                ease: 'power4.out',
                scrollTrigger: {
                    trigger: heading,
                    start: 'top 88%',
                    once: true,
                },
            }
        );
    });
}

/*
|--------------------------------------------------------------------------
| 3. SCROLL REVEAL — GSAP + SCROLLTRIGGER
|--------------------------------------------------------------------------
*/

function setupScrollReveal() {
    if (reduceMotion) return;

    const elements = document.querySelectorAll(
        '[data-scroll-reveal]'
    );

    elements.forEach((element) => {
        if (element.dataset.scrollInitialized === 'true') {
            return;
        }

        element.dataset.scrollInitialized = 'true';

        gsap.fromTo(
            element,
            {
                opacity: 0,
                y: 30,
            },
            {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                clearProps: 'transform',
                scrollTrigger: {
                    trigger: element,
                    start: 'top 90%',
                    once: true,
                },
            }
        );
    });
}

/*
|--------------------------------------------------------------------------
| 4. MOTION — PAGE ENTRANCE
|--------------------------------------------------------------------------
*/

function setupPageEntrance() {
    if (reduceMotion) return;

    const elements = document.querySelectorAll(
        '[data-page-enter]'
    );

    elements.forEach((element) => {
        if (element.dataset.pageEnterInitialized === 'true') {
            return;
        }

        element.dataset.pageEnterInitialized = 'true';

        animate(
            element,
            {
                opacity: [0, 1],
                transform: [
                    'translateY(18px)',
                    'translateY(0px)',
                ],
            },
            {
                duration: 0.75,
                easing: [0.22, 1, 0.36, 1],
            }
        );
    });
}

/*
|--------------------------------------------------------------------------
| 5. MOTION — PAGE COVER
|--------------------------------------------------------------------------
*/

function setupPageCover() {
    if (reduceMotion) return;

    const cover = document.querySelector('[data-page-cover]');

    if (!cover) return;

    // Animasi cover saat halaman selesai dimuat.
    animate(
        cover,
        {
            clipPath: [
                'inset(0% 0% 0% 0%)',
                'inset(0% 0% 100% 0%)',
            ],
        },
        {
            duration: 0.8,
            easing: [0.76, 0, 0.24, 1],
        }
    );
}

/*
|--------------------------------------------------------------------------
| 6. MOTION — TRANSISI ANTAR HALAMAN
|--------------------------------------------------------------------------
*/

function setupPageTransitions() {
    if (reduceMotion) return;

    document.addEventListener('click', async (event) => {
        const link = event.target.closest(
            'a[data-page-transition]'
        );

        if (!link) return;

        // Abaikan klik yang membuka tab baru atau unduhan.
        if (
            event.defaultPrevented ||
            event.button !== 0 ||
            event.metaKey ||
            event.ctrlKey ||
            event.shiftKey ||
            event.altKey ||
            link.target === '_blank' ||
            link.hasAttribute('download')
        ) {
            return;
        }

        const destination = new URL(link.href, window.location.href);

        if (
            destination.origin !== window.location.origin ||
            destination.href === window.location.href
        ) {
            return;
        }

        const cover = document.querySelector('[data-page-cover]');

        if (!cover) return;

        event.preventDefault();

        // Cegah klik berulang selama transisi.
        if (document.body.dataset.pageTransitioning === 'true') {
            return;
        }

        document.body.dataset.pageTransitioning = 'true';

        await animate(
            cover,
            {
                clipPath: [
                    'inset(0% 0% 100% 0%)',
                    'inset(0% 0% 0% 0%)',
                ],
            },
            {
                duration: 0.65,
                easing: [0.76, 0, 0.24, 1],
            }
        ).finished;

        window.location.assign(destination.href);
    });
}

/*
|--------------------------------------------------------------------------
| 7. MOTION — CARD REVEAL
|--------------------------------------------------------------------------
*/

function setupMotionCards() {
    const cards = document.querySelectorAll(
        '[data-motion-card]'
    );

    cards.forEach((card) => {
        if (card.dataset.motionInitialized === 'true') {
            return;
        }

        card.dataset.motionInitialized = 'true';

        if (reduceMotion) return;

        // Animasi kemunculan card.
        inView(
            card,
            () => {
                if (card.dataset.motionRevealed === 'true') {
                    return;
                }

                card.dataset.motionRevealed = 'true';

                animate(
                    card,
                    {
                        opacity: [0, 1],
                        transform: [
                            'translateY(22px)',
                            'translateY(0px)',
                        ],
                    },
                    {
                        duration: 0.7,
                        easing: [0.22, 1, 0.36, 1],
                    }
                );
            },
            {
                margin: '0px 0px -8% 0px',
            }
        );

        // Hover hanya untuk perangkat desktop.
        if (canHover) {
            card.addEventListener('pointerenter', () => {
                animate(
                    card,
                    {
                        boxShadow: '0 16px 36px rgba(0,0,0,0.16)',
                    },
                    {
                        duration: 0.25,
                        easing: 'ease-out',
                    }
                );
            });

            card.addEventListener('pointerleave', () => {
                animate(
                    card,
                    {
                        boxShadow: '0 0px 0px rgba(0,0,0,0)',
                    },
                    {
                        duration: 0.25,
                        easing: 'ease-out',
                    }
                );
            });
        }
    });
}

/*
|--------------------------------------------------------------------------
| 8. MOTION — BUTTON PRESS FEEDBACK
|--------------------------------------------------------------------------
*/

function setupPressFeedback() {
    if (reduceMotion) return;

    const selector = [
        'button',
        '[role="button"]',
        '[data-motion-press]',
        '.btn',
        '.button',
    ].join(',');

    document.addEventListener('pointerdown', (event) => {
        const element = event.target.closest(selector);

        if (
            !element ||
            element.disabled ||
            element.getAttribute('aria-disabled') === 'true'
        ) {
            return;
        }

        animate(
            element,
            {
                scale: 0.97,
            },
            {
                duration: 0.1,
                easing: 'ease-out',
            }
        );
    });

    const release = (event) => {
        const element = event.target.closest(selector);

        if (!element) return;

        animate(
            element,
            {
                scale: 1,
            },
            {
                duration: 0.16,
                easing: 'ease-out',
            }
        );
    };

    document.addEventListener('pointerup', release);
    document.addEventListener('pointercancel', release);
}

/*
|--------------------------------------------------------------------------
| 9. MOTION — MODAL / PANEL TRANSITIONS
|--------------------------------------------------------------------------
*/

function setupPanelTransitions() {
    if (reduceMotion) return;

    const selector = [
        '[data-motion-panel]',
        '[data-motion-modal]',
    ].join(',');

    const animatedElements = new WeakSet();

    function isVisible(element) {
        if (element.hidden) return false;

        if (element.getAttribute('aria-hidden') === 'true') {
            return false;
        }

        const style = window.getComputedStyle(element);

        return (
            style.display !== 'none' &&
            style.visibility !== 'hidden'
        );
    }

    function animatePanel(element) {
        if (!isVisible(element)) return;

        if (animatedElements.has(element)) return;

        animatedElements.add(element);

        animate(
            element,
            {
                opacity: [0, 1],
                transform: [
                    'translateY(14px) scale(0.985)',
                    'translateY(0px) scale(1)',
                ],
            },
            {
                duration: 0.35,
                easing: [0.22, 1, 0.36, 1],
            }
        );
    }

    function scanElement(element) {
        if (!(element instanceof HTMLElement)) return;

        if (element.matches(selector)) {
            animatePanel(element);
        }

        element.querySelectorAll(selector).forEach(animatePanel);
    }

    document.querySelectorAll(selector).forEach(animatePanel);

    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(scanElement);
                return;
            }

            const element = mutation.target;

            if (!(element instanceof HTMLElement)) return;

            if (!element.matches(selector)) return;

            if (!isVisible(element)) {
                animatedElements.delete(element);
            } else {
                animatePanel(element);
            }
        });
    });

    observer.observe(document.body, {
        subtree: true,
        childList: true,
        attributes: true,
        attributeFilter: [
            'class',
            'style',
            'hidden',
            'aria-hidden',
        ],
    });
}

/*
|--------------------------------------------------------------------------
| 10. SCROLLTRIGGER REFRESH
|--------------------------------------------------------------------------
*/

function refreshScroll() {
    requestAnimationFrame(() => {
        ScrollTrigger.refresh();
    });
}

function setupScrollRefresh() {
    if (document.fonts?.ready) {
        document.fonts.ready.then(refreshScroll);
    }

    window.addEventListener('load', refreshScroll, {
        once: true,
    });

    window.addEventListener('resize', refreshScroll, {
        passive: true,
    });
}

/*
|--------------------------------------------------------------------------
| 11. INITIALIZATION
|--------------------------------------------------------------------------
*/

function initializeKosHavenMotion() {
    setupPageCover();
    setupPageEntrance();
    setupPageTransitions();

    setupWordReveal();
    setupScrollReveal();

    setupMotionCards();
    setupPressFeedback();
    setupPanelTransitions();

    setupScrollRefresh();
}

if (document.readyState === 'loading') {
    document.addEventListener(
        'DOMContentLoaded',
        initializeKosHavenMotion,
        { once: true }
    );
} else {
    initializeKosHavenMotion();
}


@once
<style>
    .kh-logout-overlay {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(8, 12, 18, .72);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        opacity: 0;
        visibility: hidden;
        transition: opacity .25s ease, visibility .25s ease;
    }

    .kh-logout-overlay.is-visible {
        opacity: 1;
        visibility: visible;
    }

    .kh-logout-modal {
        position: relative;
        width: 100%;
        max-width: 400px;
        padding: 32px;
        background: #171D25;
        border: 1px solid rgba(255, 255, 255, .09);
        border-radius: 18px;
        box-shadow: 0 24px 70px rgba(0, 0, 0, .4);
        text-align: center;
        transform: translateY(15px) scale(.98);
        transition: transform .25s ease;
    }

    .kh-logout-overlay.is-visible .kh-logout-modal {
        transform: translateY(0) scale(1);
    }

    .kh-logout-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 62px;
        height: 62px;
        margin: 0 auto 20px;
        color: #D58F8F;
        background: rgba(213, 143, 143, .1);
        border: 1px solid rgba(213, 143, 143, .2);
        border-radius: 50%;
        font-size: 25px;
    }

    .kh-logout-title {
        margin: 0 0 10px;
        color: #F4F1EA;
        font-family: 'DM Sans', sans-serif;
        font-size: 21px;
        font-weight: 700;
    }

    .kh-logout-description {
        margin: 0 0 27px;
        color: #AEB7C0;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        line-height: 1.7;
    }

    .kh-logout-actions {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .kh-logout-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 11px 18px;
        border-radius: 9px;
        font-family: 'DM Sans', sans-serif;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s ease;
        text-decoration: none;
    }

    .kh-logout-cancel {
        flex: 1;
        color: #C5CBD1;
        background: rgba(255, 255, 255, .05);
        border: 1px solid rgba(255, 255, 255, .1);
    }

    .kh-logout-cancel:hover {
        color: #FFFFFF;
        background: rgba(255, 255, 255, .1);
    }

    .kh-logout-confirm {
        flex: 1;
        color: #FFFFFF;
        background: #A85F5F;
        border: 1px solid #A85F5F;
    }

    .kh-logout-confirm:hover {
        background: #BD7070;
        border-color: #BD7070;
    }

    .kh-logout-trigger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: auto;
        padding: 10px 14px;
        color: #D58F8F;
        background: rgba(213, 143, 143, .07);
        border: 1px solid rgba(213, 143, 143, .12);
        border-radius: 9px;
        font-family: 'DM Sans', sans-serif;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s ease;
    }

    .kh-logout-trigger:hover {
        color: #E5AAAA;
        background: rgba(213, 143, 143, .15);
        border-color: rgba(213, 143, 143, .25);
    }

    .kh-logout-trigger:focus-visible,
    .kh-logout-btn:focus-visible {
        outline: 2px solid #D9B77A;
        outline-offset: 3px;
    }

    @media (max-width: 480px) {
        .kh-logout-overlay {
            padding: 16px;
        }

        .kh-logout-modal {
            max-width: 100%;
            padding: 27px 22px;
            border-radius: 15px;
        }

        .kh-logout-title {
            font-size: 19px;
        }

        .kh-logout-actions {
            gap: 9px;
        }

        .kh-logout-btn {
            padding: 11px 12px;
            font-size: 11px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .kh-logout-overlay,
        .kh-logout-modal,
        .kh-logout-btn,
        .kh-logout-trigger {
            transition: none;
        }
    }
</style>
@endonce

<button
    type="button"
    class="kh-logout-trigger"
    data-kh-logout-open
    aria-haspopup="dialog"
    aria-controls="khLogoutModal"
>
    <i class="bi bi-box-arrow-left"></i>
    <span>Keluar dari akun</span>
</button>

<div
    id="khLogoutModal"
    class="kh-logout-overlay"
    aria-hidden="true"
>
    <section
        class="kh-logout-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="khLogoutTitle"
        aria-describedby="khLogoutDescription"
    >
        <div class="kh-logout-icon">
            <i class="bi bi-box-arrow-right"></i>
        </div>

        <h2 class="kh-logout-title" id="khLogoutTitle">
            Konfirmasi Logout
        </h2>

        <p class="kh-logout-description" id="khLogoutDescription">
            Apakah kamu yakin ingin logout dari akun KosHaven?
        </p>

        <div class="kh-logout-actions">
            <button
                type="button"
                class="kh-logout-btn kh-logout-cancel"
                data-kh-logout-close
            >
                Batal
            </button>

            <form
                action="{{ route('logout') }}"
                method="POST"
                style="flex: 1; display: flex;"
            >
                @csrf

                <button
                    type="submit"
                    class="kh-logout-btn kh-logout-confirm"
                    style="width: 100%;"
                >
                    Ya, Logout
                </button>
            </form>
        </div>
    </section>
</div>

@once
<script>
(function () {
    function initializeLogoutModal() {
       const modal = document.getElementById('khLogoutModal');

        if (!modal || modal.dataset.initialized === 'true') return;

        // Pindahkan modal langsung ke body agar tidak terpengaruh
        // transform, overflow, dan stacking context dari sidebar.
        if (modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }

        const closeButton = modal.querySelector('[data-kh-logout-close]');
        const openButtons = document.querySelectorAll('[data-kh-logout-open]');

        if (!closeButton || openButtons.length === 0) {
            return;
        }

        modal.dataset.initialized = 'true';

        let previousFocus = null;
        let previousBodyOverflow = '';

        function openModal() {
            previousFocus = document.activeElement;
            previousBodyOverflow = document.body.style.overflow;

            modal.classList.add('is-visible');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            closeButton.focus();
        }

        function closeModal() {
            if (!modal.classList.contains('is-visible')) {
                return;
            }

            modal.classList.remove('is-visible');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = previousBodyOverflow;

            if (previousFocus && typeof previousFocus.focus === 'function') {
                previousFocus.focus();
            }
        }

        openButtons.forEach(function (button) {
            button.addEventListener('click', openModal);
        });

        closeButton.addEventListener('click', closeModal);

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (!modal.classList.contains('is-visible')) {
                return;
            }

            if (event.key === 'Escape') {
                closeModal();
                return;
            }

            if (event.key === 'Tab') {
                const focusable = modal.querySelectorAll(
                    'button:not(:disabled), input:not(:disabled), a[href], [tabindex]:not([tabindex="-1"])'
                );

                if (focusable.length === 0) {
                    return;
                }

                const first = focusable[0];
                const last = focusable[focusable.length - 1];

                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (
                    !event.shiftKey &&
                    document.activeElement === last
                ) {
                    event.preventDefault();
                    first.focus();
                }
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeLogoutModal);
    } else {
        initializeLogoutModal();
    }
})();
</script>
@endonce

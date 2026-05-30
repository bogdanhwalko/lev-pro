<?php
/** @var yii\web\View $this */

use yii\helpers\Url;
use yii\web\View;

$actionUrl = Url::to(['/site/quick-contact']);

$this->registerCss(<<<CSS
/* ===== Quick contact floating widget ===== */
.qc-fab {
    position: fixed;
    right: 24px;
    bottom: 24px;
    width: 62px;
    height: 62px;
    border: none;
    border-radius: 50%;
    background: #ffba00;
    color: #1a1a1a;
    font-size: 26px;
    cursor: pointer;
    z-index: 9998;
    box-shadow: 0 8px 24px rgba(0,0,0,.28);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform .2s ease, background .2s ease;
    animation: qcBlink 1.6s ease-in-out infinite;
}
.qc-fab:hover { transform: scale(1.08); background: #ffc733; }
/* pulsing ring */
.qc-fab::after {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: #ffba00;
    z-index: -1;
    animation: qcPulse 1.8s ease-out infinite;
}
@keyframes qcBlink {
    0%, 100% { box-shadow: 0 8px 24px rgba(0,0,0,.28), 0 0 0 0 rgba(255,186,0,.0); }
    50%      { box-shadow: 0 8px 24px rgba(0,0,0,.28), 0 0 0 6px rgba(255,186,0,.45); }
}
@keyframes qcPulse {
    0%   { transform: scale(1);   opacity: .55; }
    100% { transform: scale(1.9); opacity: 0; }
}

.qc-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.55);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
}
.qc-overlay.qc-open { display: flex; }

.qc-dialog {
    background: #fff;
    width: 100%;
    max-width: 420px;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,.4);
    animation: qcSlideUp .25s ease;
}
@keyframes qcSlideUp {
    from { transform: translateY(20px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}
.qc-head {
    background: #1a1a1a;
    color: #fff;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.qc-head h4 { margin: 0; font-size: 18px; font-weight: 600; }
.qc-head p  { margin: 2px 0 0; font-size: 12.5px; color: #cfcfcf; }
.qc-close {
    background: none; border: none; color: #fff;
    font-size: 24px; line-height: 1; cursor: pointer; opacity: .8;
}
.qc-close:hover { opacity: 1; }

.qc-body { padding: 20px; }
.qc-body label { display: block; font-size: 13px; font-weight: 600; margin: 0 0 5px; color: #333; }
.qc-body input,
.qc-body textarea {
    width: 100%;
    border: 1px solid #d8d8d8;
    border-radius: 8px;
    padding: 11px 13px;
    font-size: 14px;
    margin-bottom: 14px;
    outline: none;
    transition: border-color .15s ease;
}
.qc-body input:focus,
.qc-body textarea:focus { border-color: #ffba00; }
.qc-body textarea { resize: vertical; min-height: 90px; }

.qc-submit {
    width: 100%;
    border: none;
    background: #ffba00;
    color: #1a1a1a;
    font-weight: 700;
    font-size: 15px;
    padding: 13px;
    border-radius: 8px;
    cursor: pointer;
    transition: background .2s ease;
}
.qc-submit:hover { background: #ffc733; }
.qc-submit:disabled { opacity: .6; cursor: default; }

.qc-status { font-size: 13.5px; margin-top: 12px; text-align: center; }
.qc-status.qc-ok  { color: #1a8a3a; }
.qc-status.qc-err { color: #d33; }
.qc-field-err { color: #d33; font-size: 12px; margin: -10px 0 12px; }

@media (max-width: 480px) {
    .qc-fab { right: 16px; bottom: 16px; width: 56px; height: 56px; font-size: 23px; }
    .qc-scrollzone { height: 160px; width: 40px; }
}

/* ===== Scroll-to-top clickable area (right edge, middle) ===== */
/* hide the theme's visible scroll-to-top button — replaced by the area below */
button.scroltop { display: none !important; }

.qc-scrollzone {
    position: fixed;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 48px;
    height: 220px;
    z-index: 9996;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity .3s ease;
}
.qc-scrollzone.qc-visible {
    opacity: 1;
    pointer-events: auto;
}
/* subtle hint that only shows on hover, so it reads as an area, not a button */
.qc-scrollzone .qc-scrollzone-hint {
    width: 34px;
    height: 34px;
    border-radius: 50% 0 0 50%;
    background: rgba(26,26,26,.18);
    color: #1a1a1a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    opacity: 0;
    transform: translateX(6px);
    transition: opacity .25s ease, transform .25s ease, background .2s ease;
}
/* show the hint whenever scrolling up is possible */
.qc-scrollzone.qc-visible .qc-scrollzone-hint {
    opacity: 1;
    transform: translateX(0);
}
.qc-scrollzone:hover .qc-scrollzone-hint {
    background: #ffba00;
}
CSS);

$js = <<<JS
(function () {
    var fab     = document.getElementById('qc-fab');
    var overlay = document.getElementById('qc-overlay');
    var form    = document.getElementById('qc-form');
    if (!fab || !overlay || !form) return;

    var statusEl = form.querySelector('.qc-status');
    var submitBtn = form.querySelector('.qc-submit');

    function open()  { overlay.classList.add('qc-open'); }
    function close() { overlay.classList.remove('qc-open'); }

    fab.addEventListener('click', open);
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) close();
    });
    overlay.querySelectorAll('[data-qc-close]').forEach(function (el) {
        el.addEventListener('click', close);
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') close();
    });

    // Scroll-to-top clickable area (right edge, middle)
    var scrollzone = document.getElementById('qc-scrollzone');
    if (scrollzone) {
        var scrollToTop = function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };
        scrollzone.addEventListener('click', scrollToTop);
        scrollzone.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); scrollToTop(); }
        });
        var toggleZone = function () {
            if (window.pageYOffset > 300) {
                scrollzone.classList.add('qc-visible');
            } else {
                scrollzone.classList.remove('qc-visible');
            }
        };
        window.addEventListener('scroll', toggleZone, { passive: true });
        toggleZone();
    }

    function clearErrors() {
        form.querySelectorAll('.qc-field-err').forEach(function (n) { n.textContent = ''; });
        statusEl.textContent = '';
        statusEl.className = 'qc-status';
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();

        var data = new FormData(form);
        var csrfParam = document.querySelector('meta[name="csrf-param"]');
        var csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfParam && csrfToken) {
            data.append(csrfParam.getAttribute('content'), csrfToken.getAttribute('content'));
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending…';

        fetch('{$actionUrl}', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: data
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            if (res.success) {
                statusEl.textContent = res.message;
                statusEl.className = 'qc-status qc-ok';
                form.reset();
                setTimeout(close, 2200);
            } else if (res.errors) {
                Object.keys(res.errors).forEach(function (field) {
                    var box = form.querySelector('.qc-field-err[data-for="' + field + '"]');
                    if (box) { box.textContent = res.errors[field]; }
                });
                statusEl.textContent = res.message || 'Please check the fields below.';
                statusEl.className = 'qc-status qc-err';
            } else {
                statusEl.textContent = res.message || 'Something went wrong.';
                statusEl.className = 'qc-status qc-err';
            }
        })
        .catch(function () {
            statusEl.textContent = 'Network error. Please try again.';
            statusEl.className = 'qc-status qc-err';
        })
        .finally(function () {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Send message';
        });
    });
})();
JS;
$this->registerJs($js, View::POS_END);
?>

<div id="qc-scrollzone" class="qc-scrollzone" role="button" tabindex="0" aria-label="Scroll to top" title="Back to top">
    <span class="qc-scrollzone-hint"><i class="fa fa-chevron-up"></i></span>
</div>

<button type="button" id="qc-fab" class="qc-fab" aria-label="Quick contact" title="Message us">
    <i class="fa fa-comments"></i>
</button>

<div id="qc-overlay" class="qc-overlay" role="dialog" aria-modal="true" aria-labelledby="qc-title">
    <div class="qc-dialog">
        <div class="qc-head">
            <div>
                <h4 id="qc-title">Message us</h4>
                <p>Leave your phone or email and we'll reply shortly.</p>
            </div>
            <button type="button" class="qc-close" data-qc-close aria-label="Close">&times;</button>
        </div>
        <div class="qc-body">
            <form id="qc-form" novalidate>
                <label for="qc-phone">Phone</label>
                <input type="tel" id="qc-phone" name="phone" placeholder="(425) 000-0000" autocomplete="tel">
                <div class="qc-field-err" data-for="phone"></div>

                <label for="qc-email">Email</label>
                <input type="email" id="qc-email" name="email" placeholder="you@example.com" autocomplete="email">
                <div class="qc-field-err" data-for="email"></div>

                <label for="qc-message">Message</label>
                <textarea id="qc-message" name="message" placeholder="Tell us about your project…" rows="4"></textarea>
                <div class="qc-field-err" data-for="message"></div>

                <button type="submit" class="qc-submit">Send message</button>
                <div class="qc-status"></div>
            </form>
        </div>
    </div>
</div>

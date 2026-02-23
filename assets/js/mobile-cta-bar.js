/**
 * Mobile CTA Bar Frontend Logic
 */
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        var bar = document.getElementById('mcta-bar');
        if (!bar) return;

        // Double check for mobile (already handled by CSS media query)
        function isMobile() {
            return window.innerWidth <= 767;
        }

        if (!isMobile()) return;

        var delay = (typeof mctaSettings !== 'undefined' && mctaSettings.delay) ? mctaSettings.delay : 3000;

        var showTimeout;
        function triggerShow() {
            if (showTimeout) clearTimeout(showTimeout);
            showTimeout = setTimeout(function() {
                // Check again if we're still on mobile after the delay (in case window was resized)
                if (isMobile() && !bar.classList.contains('is-visible')) {
                    bar.classList.add('is-visible');
                }
            }, delay);
        }

        triggerShow();
        window.addEventListener('resize', triggerShow);
    });
})();

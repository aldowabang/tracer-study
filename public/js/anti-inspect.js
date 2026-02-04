/**
 * Anti-Inspect / Disable Developer Tools
 * Mencegah pengguna biasa untuk membuka developer tools
 */

(function () {
    'use strict';

    // Disable right-click context menu
    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
        return false;
    });

    // Disable keyboard shortcuts for developer tools
    document.addEventListener('keydown', function (e) {
        // F12
        if (e.key === 'F12' || e.keyCode === 123) {
            e.preventDefault();
            return false;
        }

        // Ctrl+Shift+I (Inspect Element)
        if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i' || e.keyCode === 73)) {
            e.preventDefault();
            return false;
        }

        // Ctrl+Shift+J (Console)
        if (e.ctrlKey && e.shiftKey && (e.key === 'J' || e.key === 'j' || e.keyCode === 74)) {
            e.preventDefault();
            return false;
        }

        // Ctrl+Shift+C (Inspect)
        if (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c' || e.keyCode === 67)) {
            e.preventDefault();
            return false;
        }

        // Ctrl+U (View Source)
        if (e.ctrlKey && (e.key === 'U' || e.key === 'u' || e.keyCode === 85)) {
            e.preventDefault();
            return false;
        }

        // Ctrl+S (Save Page)
        if (e.ctrlKey && (e.key === 'S' || e.key === 's' || e.keyCode === 83)) {
            e.preventDefault();
            return false;
        }
    });

    // Disable text selection (optional - uncomment if needed)
    // document.addEventListener('selectstart', function(e) {
    //     e.preventDefault();
    //     return false;
    // });

    // Detect DevTools opening via debugger statement
    (function detectDevTools() {
        const threshold = 160;
        const widthThreshold = window.outerWidth - window.innerWidth > threshold;
        const heightThreshold = window.outerHeight - window.innerHeight > threshold;

        if (widthThreshold || heightThreshold) {
            // DevTools might be open - you can add custom behavior here
            // console.clear();
        }
    })();

    // Console warning message
    console.log('%c⚠️ PERINGATAN!', 'color: red; font-size: 40px; font-weight: bold;');
    console.log('%cIni adalah fitur browser yang ditujukan untuk developer.', 'font-size: 16px;');
    console.log('%cJika ada yang meminta Anda untuk menyalin-tempel sesuatu di sini, itu adalah penipuan.', 'font-size: 16px; color: red;');

})();

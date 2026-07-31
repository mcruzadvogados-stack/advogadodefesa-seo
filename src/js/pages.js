'use strict';

(function init() {
    document.body.style.overflowY = 'scroll';
    enableContentProtection();
    initStickyHeader();
})();

function enableContentProtection() {
    document.addEventListener('contextmenu', function(e) { e.preventDefault(); });
    document.addEventListener('dragstart',   function(e) { e.preventDefault(); });
    document.addEventListener('selectstart', function(e) { e.preventDefault(); });
}

function initStickyHeader() {
    var header = document.getElementById('header');
    if (!header) return;
    window.addEventListener('scroll', function() {
        header.classList.toggle('sticky', window.scrollY >= 80);
    });
}
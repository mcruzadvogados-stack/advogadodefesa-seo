'use strict';

(function init() {
    document.body.style.overflowY = 'scroll';
    enableContentProtection();
    initStickyHeader();
    initWhatsAppButton();
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

function initWhatsAppButton() {
    // Oculta todos os elementos whatsapp originais do CMS
    document.querySelectorAll('#whatsapp, div.whatsapp, a.whatsapp').forEach(function(el) {
        el.style.setProperty('display', 'none', 'important');
        el.style.setProperty('visibility', 'hidden', 'important');
    });

    // Wrapper fixo como referência para o badge absoluto
    var wrap = document.createElement('div');
    wrap.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:99999;width:62px;height:62px;';

    // Botão WhatsApp
    var link = document.createElement('a');
    link.href = 'https://api.whatsapp.com/send?phone=554732731422&text=Ol%C3%A1%2C%20gostaria%20de%20falar%20com%20um%20advogado.';
    link.target = '_blank';
    link.rel = 'noopener noreferrer';
    link.setAttribute('aria-label', 'Atendimento via WhatsApp');
    link.innerHTML = '<i class="fa-brands fa-whatsapp"></i>';
    link.style.cssText = 'position:absolute;inset:3px;background:#25d366;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:28px;text-decoration:none;box-shadow:0 4px 12px rgba(0,0,0,.3);transition:opacity .2s;';

    link.addEventListener('mouseover', function() { this.style.opacity = '.85'; });
    link.addEventListener('mouseout',  function() { this.style.opacity = '1'; });

    // Badge vermelho de notificação
    var badge = document.createElement('span');
    badge.textContent = '1';
    badge.style.cssText = 'position:absolute;top:0;right:0;background:#e53935;color:white;font-size:11px;font-weight:700;font-family:Arial,sans-serif;min-width:18px;height:18px;border-radius:9px;display:flex;align-items:center;justify-content:center;border:2px solid white;padding:0 3px;box-sizing:border-box;z-index:1;';

    wrap.appendChild(link);
    wrap.appendChild(badge);
    document.body.appendChild(wrap);
}
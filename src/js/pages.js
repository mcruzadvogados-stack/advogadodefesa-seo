'use strict';

(function init() {
    document.body.style.overflowY = 'scroll';
    enableContentProtection();
    initStickyHeader();
    initContatoForm();
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

function initContatoForm() {
    var form = document.getElementById('contato_form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        var nome    = (document.getElementById('form_nome')    || {}).value || '';
        var tel     = (document.getElementById('form_tel')     || {}).value || '';
        var assunto = (document.getElementById('form_assunto') || {}).value || '';
        var msg     = (document.getElementById('form_msg')     || {}).value || '';
        var hp      = (document.getElementById('form_hp')      || {}).value || '';

        if (hp) return; // honeypot anti-spam

        if (!nome.trim() || !tel.trim()) {
            alert('Por favor, preencha nome e telefone.');
            return;
        }

        var relatorio = [
            '📋 *RELATÓRIO DO SITE – advogadodefesa.com.br*',
            '*Nome:* ' + nome.trim(),
            '*Telefone:* ' + tel.trim(),
            '*Assunto:* ' + (assunto.trim() || 'Não informado'),
            '*Descrição:* ' + (msg.trim() || 'Não informada')
        ].join('\n');

        var url = 'https://api.whatsapp.com/send?phone=554732731422&text=' + encodeURIComponent(relatorio);
        window.open(url, '_blank', 'noopener,noreferrer');
    });
}
'use strict';

(function WhatsAppWidget() {

    var PHONE = '554732731422';

    var AREAS = [
        {
            label:   '⚖️ Trabalhista',
            name:    'Trabalhista',
            details: ['Demissão / FGTS', 'Horas extras não pagas', 'Assédio moral', 'Rescisão indireta', 'Outro']
        },
        {
            label:   '🏛️ Previdenciário',
            name:    'Previdenciário',
            details: ['INSS negado / cancelado', 'Pedido de aposentadoria', 'BPC / LOAS', 'Revisão de benefício', 'Outro']
        },
        {
            label:   '👨‍👩‍👧 Civil / Família',
            name:    'Civil / Família',
            details: ['Divórcio / Guarda', 'Inventário / Herança', 'Dívidas / Contratos', 'Outro']
        },
        { label: '🔒 Criminal', name: 'Criminal', details: null },
        { label: '❓ Outro',    name: 'Outro',    details: null }
    ];

    // Inicializa após DOM pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        hideCmsWhatsApp();
        document.body.appendChild(buildContainer());
    }

    // ── Oculta elementos originais do CMS ────────────────────────

    function hideCmsWhatsApp() {
        document.querySelectorAll('#whatsapp, div.whatsapp, a.whatsapp').forEach(function(el) {
            el.style.setProperty('display',     'none',   'important');
            el.style.setProperty('visibility',  'hidden', 'important');
        });
    }

    // ── Container principal ──────────────────────────────────────

    function buildContainer() {
        var container = el('div',
            'position:fixed;bottom:24px;right:24px;z-index:99999;' +
            'display:flex;flex-direction:column;align-items:flex-end;gap:10px;');

        var panel = buildPanel();
        var fab   = buildFab(panel);

        container.appendChild(panel);
        container.appendChild(fab);
        return container;
    }

    // ── Botão flutuante ──────────────────────────────────────────

    function buildFab(panel) {
        var wrap = el('div', 'position:relative;width:62px;height:62px;');

        var btn = el('div',
            'position:absolute;inset:3px;background:#25d366;border-radius:50%;' +
            'display:flex;align-items:center;justify-content:center;color:#fff;' +
            'font-size:28px;box-shadow:0 4px 12px rgba(0,0,0,.3);cursor:pointer;' +
            'transition:opacity .2s;user-select:none;');
        btn.setAttribute('role',       'button');
        btn.setAttribute('tabindex',   '0');
        btn.setAttribute('aria-label', 'Abrir atendimento via WhatsApp');
        btn.innerHTML = '<i class="fa-brands fa-whatsapp" aria-hidden="true"></i>';

        btn.addEventListener('mouseover', function() { btn.style.opacity = '.85'; });
        btn.addEventListener('mouseout',  function() { btn.style.opacity = '1';   });
        btn.addEventListener('click',   function() { togglePanel(panel); });
        btn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') togglePanel(panel);
        });

        var badge = el('span',
            'position:absolute;top:0;right:0;background:#e53935;color:#fff;' +
            'font-size:11px;font-weight:700;font-family:Arial,sans-serif;' +
            'min-width:18px;height:18px;border-radius:9px;display:flex;' +
            'align-items:center;justify-content:center;border:2px solid #fff;' +
            'padding:0 3px;box-sizing:border-box;pointer-events:none;');
        badge.setAttribute('aria-hidden', 'true');
        badge.textContent = '1';

        wrap.appendChild(btn);
        wrap.appendChild(badge);
        return wrap;
    }

    // ── Painel de chat ───────────────────────────────────────────

    function buildPanel() {
        var panel = el('div',
            'display:none;flex-direction:column;width:300px;max-height:460px;' +
            'background:#fff;border-radius:12px;' +
            'box-shadow:0 8px 32px rgba(0,0,0,.25);overflow:hidden;' +
            'font-family:Arial,sans-serif;font-size:14px;');

        var msgArea = el('div',
            'flex:1;overflow-y:auto;padding:12px;background:#ece5dd;' +
            'display:flex;flex-direction:column;gap:8px;');

        var btnArea = el('div',
            'padding:8px 10px;background:#f0f0f0;display:flex;flex-wrap:wrap;' +
            'gap:6px;border-top:1px solid #ddd;min-height:50px;align-content:center;');

        panel.appendChild(buildHeader());
        panel.appendChild(msgArea);
        panel.appendChild(btnArea);

        // Inicia o fluxo na primeira abertura
        var started = false;
        new MutationObserver(function() {
            if (panel.style.display !== 'none' && !started) {
                started = true;
                injectAnimStyle();
                startFlow(msgArea, btnArea);
            }
        }).observe(panel, { attributes: true, attributeFilter: ['style'] });

        return panel;
    }

    function buildHeader() {
        var h = el('div',
            'background:#075e54;color:#fff;padding:10px 14px;' +
            'display:flex;align-items:center;gap:10px;flex-shrink:0;');
        h.innerHTML =
            '<div style="width:38px;height:38px;background:#25d366;border-radius:50%;' +
            'display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;" aria-hidden="true">' +
                '<i class="fa-brands fa-whatsapp"></i>' +
            '</div>' +
            '<div>' +
                '<div style="font-weight:700;font-size:13px;">CRUZ Advocacia</div>' +
                '<div style="font-size:11px;opacity:.8;">● Online agora</div>' +
            '</div>';
        return h;
    }

    // ── Fluxo conversacional ─────────────────────────────────────

    function startFlow(msgArea, btnArea) {
        var answers = {};

        // Envia mensagem do bot com indicador de digitação
        function bot(text, delay, cb) {
            setTimeout(function() {
                showTyping(msgArea, function() {
                    addBubble(msgArea, text, false);
                    if (cb) cb();
                });
            }, delay || 0);
        }

        // Renderiza botões de opção
        function choices(opts, key, cb) {
            clearEl(btnArea);
            opts.forEach(function(label) {
                var b = el('button',
                    'background:#25d366;color:#fff;border:none;border-radius:16px;' +
                    'padding:6px 12px;font-size:12px;cursor:pointer;' +
                    'font-family:Arial,sans-serif;white-space:nowrap;');
                b.textContent = label;
                b.addEventListener('click', function() {
                    clearEl(btnArea);
                    if (key) answers[key] = label;
                    addBubble(msgArea, label, true);
                    cb(label);
                });
                btnArea.appendChild(b);
            });
        }

        // Pergunta de tempo (compartilhada entre áreas)
        function askTempo() {
            bot('Há quanto tempo ocorreu isso?', 600, function() {
                choices(
                    ['Menos de 1 mês', '1 a 6 meses', '6 meses a 2 anos', 'Mais de 2 anos'],
                    'tempo',
                    function() { showClosing(); }
                );
            });
        }

        // Mensagem final + abre WhatsApp
        function showClosing() {
            bot('Entendido. 📋 Já ajudamos +4.000 clientes em situações como a sua.', 600, function() {
            bot('⚠️ Importante: casos como o seu têm prazo legal. Quanto antes agir, melhor!', 1000, function() {
            bot('Conectando você com o Dr. Cruz agora... ⏳', 800, function() {
                setTimeout(function() { openWhatsApp(answers); }, 1200);
            }); }); });
        }

        // Início do fluxo
        bot('Olá! 👋 Aqui é a CRUZ Advocacia.', 400, function() {
        bot('Para te conectar com o advogado certo, vou te fazer 3 perguntinhas rápidas. Pode ser? 😊', 1000, function() {
            choices(['Pode! Vamos lá ✅'], null, function() {

                bot('Qual área melhor descreve sua situação?', 600, function() {
                    choices(AREAS.map(function(a) { return a.label; }), null, function(label) {
                        var area = AREAS.find(function(a) { return a.label === label; });
                        answers.area = area.name;

                        if (area.details) {
                            bot('O que melhor descreve seu caso?', 600, function() {
                                choices(area.details, 'detalhe', function() { askTempo(); });
                            });
                        } else {
                            askTempo();
                        }
                    });
                });

            });
        }); });
    }

    // ── Helpers de UI ────────────────────────────────────────────

    function togglePanel(panel) {
        panel.style.display = panel.style.display === 'none' ? 'flex' : 'none';
    }

    function showTyping(msgArea, cb) {
        var wrap = el('div',
            'background:#fff;border-radius:12px 12px 12px 0;padding:10px 14px;' +
            'align-self:flex-start;box-shadow:0 1px 2px rgba(0,0,0,.15);' +
            'display:flex;gap:4px;');

        ['0s', '0.2s', '0.4s'].forEach(function(delay) {
            var dot = el('span',
                'width:7px;height:7px;background:#aaa;border-radius:50%;' +
                'animation:wppDot .9s infinite;animation-delay:' + delay + ';');
            wrap.appendChild(dot);
        });

        msgArea.appendChild(wrap);
        scrollBottom(msgArea);

        setTimeout(function() {
            if (wrap.parentNode) wrap.parentNode.removeChild(wrap);
            cb();
        }, 850);
    }

    function addBubble(msgArea, text, isUser) {
        var bubble = el('div',
            isUser
                ? 'background:#dcf8c6;border-radius:12px 12px 0 12px;padding:8px 12px;' +
                  'max-width:80%;align-self:flex-end;box-shadow:0 1px 2px rgba(0,0,0,.15);' +
                  'word-break:break-word;line-height:1.4;'
                : 'background:#fff;border-radius:12px 12px 12px 0;padding:8px 12px;' +
                  'max-width:80%;align-self:flex-start;box-shadow:0 1px 2px rgba(0,0,0,.15);' +
                  'word-break:break-word;line-height:1.4;');
        bubble.textContent = text;
        msgArea.appendChild(bubble);
        scrollBottom(msgArea);
    }

    function clearEl(container) {
        while (container.firstChild) container.removeChild(container.firstChild);
    }

    function scrollBottom(container) { container.scrollTop = container.scrollHeight; }

    function el(tag, cssText) {
        var node = document.createElement(tag);
        if (cssText) node.style.cssText = cssText;
        return node;
    }

    function injectAnimStyle() {
        if (document.getElementById('wpp-widget-style')) return;
        var style = document.createElement('style');
        style.id = 'wpp-widget-style';
        style.textContent = '@keyframes wppDot{0%,80%,100%{opacity:.2;transform:scale(.8)}40%{opacity:1;transform:scale(1)}}';
        document.head.appendChild(style);
    }

    // ── Abre WhatsApp com contexto pré-preenchido ────────────────

    function openWhatsApp(answers) {
        var lines = ['Olá! Vim pelo site da CRUZ Advocacia.\n'];
        lines.push('📋 Área: '   + (answers.area    || ''));
        if (answers.detalhe) lines.push('📌 Caso: '    + answers.detalhe);
        if (answers.tempo)   lines.push('⏰ Ocorreu: ' + answers.tempo);
        lines.push('\nGostaria de uma análise do meu caso.');

        window.open(
            'https://api.whatsapp.com/send?phone=' + PHONE +
            '&text=' + encodeURIComponent(lines.join('\n')),
            '_blank',
            'noopener,noreferrer'
        );
    }

})();

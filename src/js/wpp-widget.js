'use strict';

(function WhatsAppWidget() {

    // ── Configuração ─────────────────────────────────────────────
    const PHONE          = '5547991313686';
    const INACTIVITY_MS  = 8000;

    // Ícone WhatsApp como SVG inline (independente do Font Awesome)
    const WPP_ICON = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" aria-hidden="true" style="width:1em;height:1em;vertical-align:-.125em"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>';

    const AREAS = [
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

    // ── Bootstrap ─────────────────────────────────────────────────
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        hideCmsWhatsApp();
        injectWidgetStyles();
        document.body.appendChild(buildWidget());
    }

    function injectWidgetStyles() {
        if (document.getElementById('wpp-widget-style')) return;
        const style = document.createElement('style');
        style.id = 'wpp-widget-style';
        style.textContent =
            '@keyframes wppDot{0%,80%,100%{opacity:.2;transform:scale(.8)}40%{opacity:1;transform:scale(1)}}' +
            '@keyframes wppPulse{0%{transform:scale(1);opacity:.6}70%{transform:scale(1.8);opacity:0}100%{transform:scale(1.8);opacity:0}}';
        document.head.appendChild(style);
    }

    // ── Oculta elementos originais do CMS ────────────────────────
    function hideCmsWhatsApp() {
        document.querySelectorAll('#whatsapp, div.whatsapp, a.whatsapp').forEach(el => {
            el.style.setProperty('display',    'none',   'important');
            el.style.setProperty('visibility', 'hidden', 'important');
        });
    }

    // ── Widget (container + painel + botão) ───────────────────────
    function buildWidget() {
        const container = createElement('div',
            'position:fixed;bottom:24px;right:24px;z-index:99999;' +
            'display:flex;flex-direction:column;align-items:flex-end;gap:10px;');

        const panel = buildPanel();
        const fab   = buildFab(panel);

        container.appendChild(panel);
        container.appendChild(fab);
        return container;
    }

    // ── Botão flutuante ───────────────────────────────────────────
    function buildFab(panel) {
        const wrap = createElement('div', 'position:relative;width:62px;height:62px;');

        const pulse = createElement('div',
            'position:absolute;inset:3px;border-radius:50%;' +
            'background:rgba(37,211,102,.45);' +
            'animation:wppPulse 1.8s ease-out infinite;');
        wrap.appendChild(pulse);

        const btn = createElement('div',
            'position:absolute;inset:3px;background:#25d366;border-radius:50%;' +
            'display:flex;align-items:center;justify-content:center;color:#fff;' +
            'font-size:28px;box-shadow:0 4px 12px rgba(0,0,0,.3);cursor:pointer;' +
            'transition:opacity .2s;user-select:none;');
        btn.setAttribute('role',       'button');
        btn.setAttribute('tabindex',   '0');
        btn.setAttribute('aria-label', 'Abrir atendimento via WhatsApp');
        btn.innerHTML = WPP_ICON;

        btn.addEventListener('mouseover', () => { btn.style.opacity = '.85'; });
        btn.addEventListener('mouseout',  () => { btn.style.opacity = '1';   });
        btn.addEventListener('click',     () => togglePanel(panel));
        btn.addEventListener('keydown',   e  => {
            if (e.key === 'Enter' || e.key === ' ') togglePanel(panel);
        });

        const badge = createElement('span',
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

    // ── Painel de chat ────────────────────────────────────────────
    function buildPanel() {
        const panel = createElement('div',
            'display:none;flex-direction:column;width:300px;max-height:460px;' +
            'background:#fff;border-radius:12px;' +
            'box-shadow:0 8px 32px rgba(0,0,0,.25);overflow:hidden;' +
            'font-family:Arial,sans-serif;font-size:14px;');

        const msgArea = createElement('div',
            'flex:1;overflow-y:auto;padding:12px;background:#ece5dd;' +
            'display:flex;flex-direction:column;gap:8px;');

        const btnArea = createElement('div',
            'padding:8px 10px;background:#f0f0f0;display:flex;flex-wrap:wrap;' +
            'gap:6px;border-top:1px solid #ddd;min-height:50px;align-content:center;');

        panel.appendChild(buildHeader());
        panel.appendChild(msgArea);
        panel.appendChild(btnArea);

        attachInactivityTimer(panel);
        attachFlowTrigger(panel, msgArea, btnArea);

        return panel;
    }

    function buildHeader() {
        const header = createElement('div',
            'background:#075e54;color:#fff;padding:10px 14px;' +
            'display:flex;align-items:center;gap:10px;flex-shrink:0;');
        header.innerHTML =
            '<div style="width:38px;height:38px;background:#25d366;border-radius:50%;' +
            'display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;" aria-hidden="true">' +
                WPP_ICON +
            '</div>' +
            '<div>' +
                '<div style="font-weight:700;font-size:13px;">CRUZ Advocacia</div>' +
                '<div style="font-size:11px;opacity:.8;">● Online agora</div>' +
            '</div>';
        return header;
    }

    // ── Timer de inatividade ──────────────────────────────────────
    function attachInactivityTimer(panel) {
        let timer = null;

        const resetTimer = () => {
            if (panel.style.display === 'none') return;
            clearTimeout(timer);
            timer = setTimeout(() => closePanel(panel), INACTIVITY_MS);
        };

        const clearTimer = () => clearTimeout(timer);

        // Expõe métodos para uso externo
        panel._startInactivityTimer = resetTimer;
        panel._clearInactivityTimer = clearTimer;

        // Qualquer interação no painel reseta o timer
        ['mousemove', 'click', 'keydown', 'touchstart'].forEach(event => {
            panel.addEventListener(event, resetTimer, { passive: true });
        });
    }

    // Inicia o fluxo conversacional na primeira vez que o painel abre
    function attachFlowTrigger(panel, msgArea, btnArea) {
        let started = false;
        new MutationObserver(() => {
            if (panel.style.display !== 'none' && !started) {
                started = true;
                startConversationFlow(msgArea, btnArea, panel);
            }
        }).observe(panel, { attributes: true, attributeFilter: ['style'] });
    }

    // ── Controle de visibilidade do painel ────────────────────────
    function togglePanel(panel) {
        if (panel.style.display === 'none') {
            openPanel(panel);
        } else {
            closePanel(panel);
        }
    }

    function openPanel(panel) {
        panel.style.display = 'flex';
        panel._startInactivityTimer();
    }

    function closePanel(panel) {
        panel._clearInactivityTimer();
        panel.style.display = 'none';
    }

    // ── Fluxo conversacional ──────────────────────────────────────
    function startConversationFlow(msgArea, btnArea, panel) {
        const answers = {};

        function sendBotMessage(text, delay, callback) {
            setTimeout(() => {
                showTypingIndicator(msgArea, () => {
                    addMessageBubble(msgArea, text, false);
                    panel._startInactivityTimer(); // reseta o timer a cada mensagem do bot
                    if (callback) callback();
                });
            }, delay || 0);
        }

        function showChoiceButtons(options, answerKey, callback) {
            clearContainer(btnArea);
            options.forEach(label => {
                const btn = createElement('button',
                    'background:#25d366;color:#fff;border:none;border-radius:16px;' +
                    'padding:6px 12px;font-size:12px;cursor:pointer;' +
                    'font-family:Arial,sans-serif;white-space:nowrap;');
                btn.textContent = label;
                btn.addEventListener('click', () => {
                    clearContainer(btnArea);
                    if (answerKey) answers[answerKey] = label;
                    addMessageBubble(msgArea, label, true);
                    callback(label);
                });
                btnArea.appendChild(btn);
            });
        }

        function askTimeframe() {
            sendBotMessage('Há quanto tempo ocorreu isso?', 600, () => {
                showChoiceButtons(
                    ['Menos de 1 mês', '1 a 6 meses', '6 meses a 2 anos', 'Mais de 2 anos'],
                    'tempo',
                    () => showClosingMessages()
                );
            });
        }

        function showClosingMessages() {
            sendBotMessage('Entendido. 📋 Já ajudamos +4.000 clientes em situações como a sua.', 600, () => {
            sendBotMessage('⚠️ Importante: casos como o seu têm prazo legal. Quanto antes agir, melhor!', 1000, () => {
            sendBotMessage('Clique abaixo para falar com o Dr. Cruz agora — suas respostas já estarão na mensagem! 👇', 800, () => {
                showWhatsAppButton(btnArea, answers, panel);
            }); }); });
        }

        // Início do fluxo
        sendBotMessage('Olá! 👋 Aqui é a CRUZ Advocacia.', 400, () => {
        sendBotMessage('Para te conectar com o advogado certo, vou te fazer 3 perguntinhas rápidas. Pode ser? 😊', 1000, () => {
            showChoiceButtons(['Pode! Vamos lá ✅'], null, () => {

                sendBotMessage('Qual área melhor descreve sua situação?', 600, () => {
                    showChoiceButtons(AREAS.map(a => a.label), null, label => {
                        const area = AREAS.find(a => a.label === label);
                        answers.area = area.name;

                        if (area.details) {
                            sendBotMessage('O que melhor descreve seu caso?', 600, () => {
                                showChoiceButtons(area.details, 'detalhe', () => askTimeframe());
                            });
                        } else {
                            askTimeframe();
                        }
                    });
                });

            });
        }); });
    }


    // ── UI helpers ────────────────────────────────────────────────
    function showTypingIndicator(msgArea, callback) {
        const wrap = createElement('div',
            'background:#fff;border-radius:12px 12px 12px 0;padding:10px 14px;' +
            'align-self:flex-start;box-shadow:0 1px 2px rgba(0,0,0,.15);' +
            'display:flex;gap:4px;');

        ['0s', '0.2s', '0.4s'].forEach(delay => {
            const dot = createElement('span',
                'width:7px;height:7px;background:#aaa;border-radius:50%;' +
                'animation:wppDot .9s infinite;animation-delay:' + delay + ';');
            wrap.appendChild(dot);
        });

        msgArea.appendChild(wrap);
        scrollToBottom(msgArea);

        setTimeout(() => {
            if (wrap.parentNode) wrap.parentNode.removeChild(wrap);
            callback();
        }, 850);
    }

    function addMessageBubble(msgArea, text, isUserMessage) {
        const bubble = createElement('div',
            isUserMessage
                ? 'background:#dcf8c6;border-radius:12px 12px 0 12px;padding:8px 12px;' +
                  'max-width:80%;align-self:flex-end;box-shadow:0 1px 2px rgba(0,0,0,.15);' +
                  'word-break:break-word;line-height:1.4;'
                : 'background:#fff;border-radius:12px 12px 12px 0;padding:8px 12px;' +
                  'max-width:80%;align-self:flex-start;box-shadow:0 1px 2px rgba(0,0,0,.15);' +
                  'word-break:break-word;line-height:1.4;');
        bubble.textContent = text;
        msgArea.appendChild(bubble);
        scrollToBottom(msgArea);
    }

    function showWhatsAppButton(btnArea, answers, panel) {
        clearContainer(btnArea);

        const link = document.createElement('a');
        link.href   = buildWhatsAppUrl(answers);
        link.target = '_blank';
        link.rel    = 'noopener noreferrer';
        link.style.cssText =
            'display:flex;align-items:center;justify-content:center;gap:8px;' +
            'background:#25d366;color:#fff;text-decoration:none;border-radius:20px;' +
            'padding:10px 18px;font-size:13px;font-weight:700;font-family:Arial,sans-serif;' +
            'width:100%;box-sizing:border-box;box-shadow:0 2px 8px rgba(0,0,0,.2);';
        link.innerHTML =
            WPP_ICON + 'Falar com o Dr. Cruz agora →';

        link.addEventListener('click', () => {
            setTimeout(() => closePanel(panel), 3000);
        });

        btnArea.appendChild(link);
    }

    function buildWhatsAppUrl(answers) {
        const lines = [
            'Olá! Acabei de responder o questionário no site da CRUZ Advocacia.',
            '',
            '*📋 Relatório do meu caso:*',
            '• Área: '                               + (answers.area    || 'Não informado'),
            answers.detalhe ? '• Situação: '  + answers.detalhe : null,
            answers.tempo   ? '• Ocorreu há: ' + answers.tempo   : null,
            '',
            'Gostaria de uma análise do meu caso.'
        ].filter(line => line !== null);

        return 'https://api.whatsapp.com/send?phone=' + PHONE +
               '&text=' + encodeURIComponent(lines.join('\n'));
    }

    // ── Utils ─────────────────────────────────────────────────────
    function createElement(tag, cssText) {
        const node = document.createElement(tag);
        if (cssText) node.style.cssText = cssText;
        return node;
    }

    function clearContainer(container) {
        while (container.firstChild) container.removeChild(container.firstChild);
    }

    function scrollToBottom(container) {
        container.scrollTop = container.scrollHeight;
    }

})();

(function () {
    var slug = location.pathname.replace(/^\/|\/$/g, '');
    var base = 'https://advogadodefesa.com.br';
    var img  = base + '/src/img/CRUZ_SOCIAL_SITE.png';

    var addr = {
        '@type': 'PostalAddress',
        streetAddress: 'Rua Ângelo Schiochet, 280, Sala 3, Centro',
        addressLocality: 'Jaraguá do Sul',
        addressRegion: 'SC',
        postalCode: '89251-520',
        addressCountry: 'BR'
    };
    var area = [
        { '@type': 'City',  name: 'Jaraguá do Sul' },
        { '@type': 'State', name: 'Santa Catarina'  }
    ];

    var pages = {
        'trabalhista':    { label: 'Direito Trabalhista' },
        'previdenciario': { label: 'Direito Previdenciário' },
        'civil':          { label: 'Direito Civil' },
        'criminal':       {
            label: 'Defesa Criminal',
            fixTitle: 'Advogado Criminal em Jaraguá do Sul/SC | Defesa Penal | CRUZ Advocacia',
            fixOg:    'Advogado Criminal em Jaraguá do Sul/SC — CRUZ Advocacia'
        },
        'bancario':   { label: 'Direito Bancário' },
        'inventario': { label: 'Inventário e Partilha' },
        'contato':    { label: 'Contato' }
    };

    var page = pages[slug];
    if (!page) return;

    var url = base + '/' + slug;

    // ── JSON-LD ──────────────────────────────────────────────────
    var graph = [
        {
            '@type': 'LegalService',
            name: 'CRUZ Advocacia',
            url: url,
            telephone: '+554732731422',
            address: addr,
            areaServed: area
        },
        {
            '@type': 'BreadcrumbList',
            itemListElement: [
                { '@type': 'ListItem', position: 1, name: 'Início', item: base + '/' },
                { '@type': 'ListItem', position: 2, name: page.label, item: url }
            ]
        }
    ];

    var ld = document.createElement('script');
    ld.type = 'application/ld+json';
    ld.text = JSON.stringify({ '@context': 'https://schema.org', '@graph': graph });
    document.head.appendChild(ld);

    // ── Meta tags faltantes ──────────────────────────────────────
    function addMeta(prop, val, attr) {
        attr = attr || 'property';
        if (!document.head.querySelector('meta[' + attr + '="' + prop + '"]')) {
            var m = document.createElement('meta');
            m.setAttribute(attr, prop);
            m.setAttribute('content', val);
            document.head.appendChild(m);
        }
    }

    addMeta('og:type',         'website');
    addMeta('og:locale',       'pt_BR');
    addMeta('og:site_name',    'CRUZ Advocacia');
    addMeta('og:image:width',  '1200');
    addMeta('og:image:height', '630');
    addMeta('theme-color',     '#1a1a2e', 'name');

    // ── Fix título criminal ──────────────────────────────────────
    if (page.fixTitle) {
        document.title = page.fixTitle;
        var ogT = document.head.querySelector('meta[property="og:title"]');
        if (ogT) ogT.setAttribute('content', page.fixOg);
    }
})();

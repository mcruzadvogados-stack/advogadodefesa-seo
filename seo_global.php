<?php
/**
 * SEO Global — CRUZ Advocacia
 * Injeta meta tags e JSON-LD faltantes com base na URL atual.
 * Incluir no final de src/partials/footer.php
 */

$uri   = strtok($_SERVER['REQUEST_URI'], '?');
$slug  = trim($uri, '/');
$base  = 'https://advogadodefesa.com.br';
$img   = $base . '/src/img/CRUZ_SOCIAL_SITE.png';
$addr  = [
    '@type'           => 'PostalAddress',
    'streetAddress'   => 'Rua Ângelo Schiochet, 280, Sala 3, Centro',
    'addressLocality' => 'Jaraguá do Sul',
    'addressRegion'   => 'SC',
    'postalCode'      => '89251-520',
    'addressCountry'  => 'BR',
];
$area = [
    ['@type' => 'City',  'name' => 'Jaraguá do Sul'],
    ['@type' => 'State', 'name' => 'Santa Catarina'],
];

$pages = [
    '' => [
        'label'   => 'Início',
        'trail'   => [],
    ],
    'trabalhista' => [
        'label'   => 'Direito Trabalhista',
        'og_type' => 'website',
        'og_loc'  => 'pt_BR',
        'trail'   => [['Direito Trabalhista', '/trabalhista']],
        'fix_title' => null,
    ],
    'previdenciario' => [
        'label'   => 'Direito Previdenciário',
        'og_type' => 'website',
        'og_loc'  => 'pt_BR',
        'trail'   => [['Direito Previdenciário', '/previdenciario']],
    ],
    'civil' => [
        'label'   => 'Direito Civil',
        'og_type' => 'website',
        'og_loc'  => 'pt_BR',
        'trail'   => [['Direito Civil', '/civil']],
    ],
    'criminal' => [
        'label'    => 'Defesa Criminal',
        'og_type'  => 'website',
        'og_loc'   => 'pt_BR',
        'trail'    => [['Defesa Criminal', '/criminal']],
        'fix_title' => 'Advogado Criminal em Jaraguá do Sul/SC | Defesa Penal | CRUZ Advocacia',
        'fix_og'    => 'Advogado Criminal em Jaraguá do Sul/SC — CRUZ Advocacia',
    ],
    'bancario' => [
        'label'   => 'Direito Bancário',
        'og_type' => 'website',
        'og_loc'  => 'pt_BR',
        'trail'   => [['Direito Bancário', '/bancario']],
    ],
    'inventario' => [
        'label'   => 'Inventário e Partilha',
        'og_type' => 'website',
        'og_loc'  => 'pt_BR',
        'trail'   => [['Inventário e Partilha', '/inventario']],
    ],
    'contato' => [
        'label'   => 'Contato',
        'og_type' => 'website',
        'og_loc'  => 'pt_BR',
        'trail'   => [['Contato', '/contato']],
    ],
];

if (!array_key_exists($slug, $pages)) {
    return;
}

$page = $pages[$slug];
$url  = $base . ($slug ? '/' . $slug : '/');

// ── BreadcrumbList ─────────────────────────────────────────────────────────────
$breadcrumb_items = [
    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Início', 'item' => $base . '/'],
];
$pos = 2;
foreach ($page['trail'] as [$name, $path]) {
    $breadcrumb_items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => $name, 'item' => $base . $path];
}

// ── LegalService ───────────────────────────────────────────────────────────────
$legal_service = [
    '@type'      => 'LegalService',
    'name'       => 'CRUZ Advocacia',
    'url'        => $url,
    'telephone'  => '+554732731422',
    'address'    => $addr,
    'areaServed' => $area,
];

$graph = [$legal_service];
if (count($breadcrumb_items) > 1) {
    $graph[] = ['@type' => 'BreadcrumbList', 'itemListElement' => $breadcrumb_items];
}

$json = json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
<!-- SEO Global — CRUZ Advocacia -->
<script type="application/ld+json"><?= $json ?></script>
<script>
(function () {
    // og:type, og:locale, og:site_name, og:image dimensions
    var head = document.head;
    function addMeta(prop, content) {
        if (!head.querySelector('meta[property="' + prop + '"]')) {
            var m = document.createElement('meta');
            m.setAttribute('property', prop);
            m.setAttribute('content', content);
            head.appendChild(m);
        }
    }
    addMeta('og:type',         'website');
    addMeta('og:locale',       'pt_BR');
    addMeta('og:site_name',    'CRUZ Advocacia');
    addMeta('og:image:width',  '1200');
    addMeta('og:image:height', '630');

    // theme-color
    if (!head.querySelector('meta[name="theme-color"]')) {
        var tc = document.createElement('meta');
        tc.name = 'theme-color';
        tc.content = '#1a1a2e';
        head.appendChild(tc);
    }
<?php if (!empty($page['fix_title'])): ?>
    // Fix criminal page title
    document.title = <?= json_encode($page['fix_title']) ?>;
    var ogT = head.querySelector('meta[property="og:title"]');
    if (ogT) ogT.setAttribute('content', <?= json_encode($page['fix_og'] ?? $page['fix_title']) ?>);
<?php endif; ?>
})();
</script>

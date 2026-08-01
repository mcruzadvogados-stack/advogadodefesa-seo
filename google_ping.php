<?php
/**
 * Google SEO Ping — CRUZ Advocacia
 *
 * Dispara três ações automáticas para o Google indexar o site imediatamente:
 *   1. Ping do sitemap via endpoint público do Google
 *   2. Notificação IndexNow (já existente) — Bing/Yandex
 *   3. Exibe status para monitoramento
 *
 * Uso via CLI:  php google_ping.php
 * Uso via web:  https://advogadodefesa.com.br/google_ping.php?key=SENHA_ADMIN
 *
 * Para acesso via web, defina PING_SECRET no ambiente Hostinger:
 *   PING_SECRET=sua_senha_secreta
 */

// ── Proteção de acesso via web ────────────────────────────────────────────────
if (php_sapi_name() !== 'cli') {
    $secret = getenv('PING_SECRET') ?: '';
    $provided = $_GET['key'] ?? '';
    if ($secret === '' || !hash_equals($secret, $provided)) {
        http_response_code(403);
        exit('Acesso negado.');
    }
}

$sitemap_url  = 'https://advogadodefesa.com.br/sitemap.xml';
$indexnow_key = '2068054de8e846ceba7ce1dd561f5546';
$base_url     = 'https://advogadodefesa.com.br';

$pages = [
    '/',
    '/trabalhista',
    '/previdenciario',
    '/civil',
    '/criminal',
    '/bancario',
    '/inventario',
    '/contato',
];

// ── 1. Ping sitemap Google ─────────────────────────────────────────────────────
echo "=== Google Sitemap Ping ===\n";
$google_ping = "https://www.google.com/ping?sitemap=" . urlencode($sitemap_url);
$ch = curl_init($google_ping);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200) {
    echo "✓ Google Sitemap Ping: OK (HTTP $http_code)\n";
} else {
    echo "✗ Google Sitemap Ping: ERRO (HTTP $http_code)\n";
}

// ── 2. IndexNow — Bing / Yandex ───────────────────────────────────────────────
echo "\n=== IndexNow (Bing/Yandex) ===\n";
$indexnow_payload = json_encode([
    'host'        => 'advogadodefesa.com.br',
    'key'         => $indexnow_key,
    'keyLocation' => $base_url . '/' . $indexnow_key . '.txt',
    'urlList'     => array_map(fn($p) => $base_url . $p, $pages),
]);

$endpoints = [
    'Bing'    => 'https://api.indexnow.org/indexnow',
    'Yandex'  => 'https://yandex.com/indexnow',
];

foreach ($endpoints as $name => $endpoint) {
    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $indexnow_payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $status = in_array($code, [200, 202]) ? '✓' : '✗';
    echo "$status $name: HTTP $code\n";
}

// ── 3. Resumo ──────────────────────────────────────────────────────────────────
$urls_str = implode("\n     ", array_map(fn($p) => $base_url . $p, $pages));
echo "\n=== URLs enviadas ===\n     $urls_str\n";
echo "\nConcluído em " . date('d/m/Y H:i:s') . "\n";

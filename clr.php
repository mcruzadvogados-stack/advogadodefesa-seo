<?php
define('DEPLOY_TOKEN', 'adv2026xK9mP3qR7nL5v');

header('X-LiteSpeed-Purge: *');
header('Cache-Control: no-store, no-cache, must-revalidate');

// ── Modo deploy: POST com token + file + content ──────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['file'])) {

    if (($_GET['token'] ?? '') !== DEPLOY_TOKEN) {
        http_response_code(403);
        die('Forbidden');
    }

    $allowed = [
        'index.php',
        'src/pages/index.php',
        'src/css/style.css',
        'src/css/430.css',
        'src/css/640.css',
        'src/css/768.css',
        'src/css/1024.css',
        'src/css/1280.css',
        'src/css/1536.css',
        'src/css/1630.css',
    ];

    $file = $_GET['file'];

    if (!in_array($file, $allowed)) {
        http_response_code(400);
        die('Not allowed: ' . $file);
    }

    $content = $_POST['content'] ?? '';
    $path    = __DIR__ . '/' . $file;
    $dir     = dirname($path);

    if (!is_dir($dir)) mkdir($dir, 0755, true);

    if (file_put_contents($path, $content) === false) {
        http_response_code(500);
        die('Write failed: ' . $file);
    }

    if (function_exists('opcache_invalidate')) opcache_invalidate($path, true);
    if (function_exists('opcache_reset'))      opcache_reset();

    echo 'OK: ' . $file;
    exit;
}

// ── Modo limpeza de cache: qualquer outro acesso ──────────────────────────
if (function_exists('opcache_reset')) opcache_reset();
echo 'Cache limpo!';

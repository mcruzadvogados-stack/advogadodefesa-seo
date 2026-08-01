<?php
define('DEPLOY_TOKEN', 'adv2026xK9mP3qR7nL5v');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die();
}

$token = $_GET['token'] ?? $_POST['token'] ?? '';
if ($token !== DEPLOY_TOKEN) {
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

$file = $_GET['file'] ?? $_POST['file'] ?? '';

if (!in_array($file, $allowed)) {
    http_response_code(400);
    die('Arquivo nao permitido: ' . $file);
}

$content = $_POST['content'] ?? '';
$path    = __DIR__ . '/' . $file;
$dir     = dirname($path);

if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

if (file_put_contents($path, $content) === false) {
    http_response_code(500);
    die('Falha ao escrever: ' . $file);
}

if (function_exists('opcache_invalidate')) {
    opcache_invalidate($path, true);
}

echo 'OK: ' . $file;

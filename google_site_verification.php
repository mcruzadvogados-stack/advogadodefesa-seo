<?php
/**
 * Verificação Google Search Console — método por arquivo HTML
 *
 * O Google pode verificar propriedade via arquivo HTML na raiz do domínio.
 * Este script serve qualquer arquivo de verificação google[CÓDIGO].html
 *
 * INSTRUÇÃO:
 *   1. No Search Console, escolha "Método de verificação HTML"
 *   2. Google mostrará: google[CÓDIGO].html com conteúdo "google-site-verification: google[CÓDIGO].html"
 *   3. Defina no ambiente Hostinger:
 *        GOOGLE_VERIFICATION_CODE=google[CÓDIGO]
 *        GOOGLE_VERIFICATION_CONTENT=google-site-verification: google[CÓDIGO].html
 *   4. No .htaccess ou nginx, redirecione google*.html para este script
 *
 * Alternativa mais simples: use a meta tag em src/pages/index.php
 *   (já configurada — basta definir GOOGLE_SITE_VERIFICATION no ambiente)
 */

$code    = getenv('GOOGLE_VERIFICATION_CODE') ?: '';
$content = getenv('GOOGLE_VERIFICATION_CONTENT') ?: '';

if ($code === '' || $content === '') {
    http_response_code(404);
    exit('Não configurado.');
}

// Serve o arquivo de verificação
$requested = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if ($requested === $code . '.html') {
    header('Content-Type: text/html; charset=utf-8');
    echo $content;
    exit;
}

http_response_code(404);
exit('Não encontrado.');

<?php
http_response_code(404);
header_remove('X-Powered-By');
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página não encontrada | CRUZ Advocacia</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/x-icon" href="/ICON.png">
    <meta name="theme-color" content="#1a1a2e">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Arial,sans-serif;background:#1a1a2e;color:#c8a96e;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:100vh;text-align:center;padding:24px}
        .logo{width:160px;margin-bottom:32px;opacity:.9}
        h1{font-size:6rem;font-weight:700;line-height:1;margin-bottom:8px;color:#c8a96e}
        h2{font-size:1.4rem;font-weight:400;margin-bottom:24px;opacity:.8}
        p{font-size:1rem;opacity:.65;max-width:420px;line-height:1.6;margin-bottom:36px}
        .btn-group{display:flex;gap:12px;flex-wrap:wrap;justify-content:center}
        a.btn{display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:700;font-size:.95rem;transition:opacity .2s}
        a.btn:hover{opacity:.85}
        .btn-primary{background:#c8a96e;color:#1a1a2e}
        .btn-wpp{background:#25d366;color:#fff}
    </style>
</head>
<body>
    <img src="/src/img/LOGO.png" alt="CRUZ Advocacia" class="logo">
    <h1>404</h1>
    <h2>Página não encontrada</h2>
    <p>A página que você procura não existe ou foi movida. Volte ao início ou fale diretamente com a nossa equipe.</p>
    <div class="btn-group">
        <a href="/" class="btn btn-primary">← Voltar ao início</a>
        <a href="https://api.whatsapp.com/send?phone=554732731422&text=Ol%C3%A1%2C%20gostaria%20de%20falar%20com%20um%20advogado." target="_blank" rel="noopener noreferrer" class="btn btn-wpp">Falar pelo WhatsApp</a>
    </div>
</body>
</html>

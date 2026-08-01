<?php

header_remove('X-Powered-By');
session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>true,'httponly'=>true,'samesite'=>'Strict']);
session_start();

$url = "INDEX";
if(isset($_GET['url'])){
    $url = strtoupper($_GET['url']);
}

// ROTAS - URL AMIGÁVEL --------------------------------------------------- //

// PÁGINA INICIAL (HOME)
if($url=="INDEX"){
    ob_start();
    require_once "src/pages/index.php";
    $html = ob_get_clean();

    // Injeta patch CSS compartilhado antes do </head>
    $patch = '<link rel="stylesheet" href="/src/css/patch.css">';

    echo str_replace('</head>', $patch . '</head>', $html);
}

?>
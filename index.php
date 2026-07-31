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

    // Injeta correções de CSS antes do </head>
    $patch = '<style id="css-patch">
/* Transparência harmoniosa */
.hero_bg_video{opacity:.40!important}
.sobre_right img,.experiencia_right img{opacity:.60!important;transition:opacity 300ms ease}
.card img{opacity:.60!important;transition:opacity 300ms ease}
/* Hover — todas as imagens voltam a 100% */
.sobre_right:hover img,.experiencia_right:hover img{opacity:1!important}
.card:hover img{opacity:1!important}
/* Seção especialidades — padding simétrico, altura adaptável */
body .section_especialidades{height:auto!important;min-height:100vh!important;padding:80px 10%!important}
</style>';

    echo str_replace('</head>', $patch . '</head>', $html);
}

?>
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
    // require_once "src/pages/_1temp.php"; //EM CONSTRUÇÃO / MANUTENÇÃO
    require_once "src/pages/index.php"; //PRODUÇÃO - OFICIAL
}


?>
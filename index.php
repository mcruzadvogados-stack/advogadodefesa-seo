<?php

    // Get full server timestamp with GMT(-03:00)
    date_default_timezone_set('America/Sao_Paulo');
    $timestamp = date('Y-m-d H:i:s');
    $now_db = date('Y-m-d');
    $data_retroativa = date('Y-m-d', strtotime($now_db. ' - 30 days'));
    $now_date = date('d/m/Y');
    $refreshkey = date('dmYhms');

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <!-- Título e Meta Description -->
    <title>CRUZ Advocacia — Advogado em Jaraguá do Sul/SC | Trabalhista, Previdenciário, Civil, Criminal</title>
    <meta name="description" content="CRUZ Advocacia — escritório de referência em Jaraguá do Sul/SC. Especialistas em Direito Trabalhista, Previdenciário, Civil, Bancário e Criminal. +4.000 clientes atendidos. Consulta via WhatsApp.">
    <meta name="keywords" content="advogado Jaraguá do Sul, advogado trabalhista SC, advogado previdenciário Jaraguá do Sul, INSS negado, escritório advocacia Santa Catarina, advogado criminal Jaraguá do Sul, advogado civil família SC, CRUZ Advocacia">
    <link rel="icon" type="image/x-icon" href="ICON.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="CRUZ Advocacia">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://www.advogadodefesa.com.br/">

    <!-- Preconnect para recursos externos -->
    <link rel="preconnect" href="https://kit.fontawesome.com" crossorigin>
    <link rel="preconnect" href="https://code.jquery.com" crossorigin>
    <link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>

    <!-- Google Analytics 4 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NCK20HDPPC"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-NCK20HDPPC');
    </script>

    <!-- Open Graph — WhatsApp, Facebook, Instagram -->
    <meta property="og:title" content="CRUZ Advocacia — Advogado em Jaraguá do Sul/SC">
    <meta property="og:description" content="Soluções jurídicas completas em Direito Trabalhista, Previdenciário, Civil, Bancário e Criminal. +4.000 clientes atendidos. Consulta via WhatsApp.">
    <meta property="og:image" content="https://www.advogadodefesa.com.br/src/img/CRUZ_SOCIAL_SITE.png">
    <meta property="og:url" content="https://www.advogadodefesa.com.br/">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="CRUZ Advocacia">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@cruzadvocacia">
    <meta name="twitter:title" content="CRUZ Advocacia — Advogado em Jaraguá do Sul/SC">
    <meta name="twitter:description" content="Soluções jurídicas completas em Direito Trabalhista, Previdenciário, Civil, Bancário e Criminal. +4.000 clientes.">
    <meta name="twitter:image" content="https://www.advogadodefesa.com.br/src/img/social_media_card.png">

    <!-- SEO GOOGLE -->
    <meta name="revisit-after" content="7 days">
    <meta name="distribution" content="Brazil">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">

    <!-- Meta Tags de Localização — Jaraguá do Sul (corrigido) -->
    <meta name="geo.region" content="BR-SC">
    <meta name="geo.placename" content="Jaraguá do Sul">
    <meta name="geo.position" content="-26.4939913;-49.0811204">
    <meta name="ICBM" content="-26.4939913, -49.0811204">

    <!-- Meta Tags para APPLE -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Meta Tags para MOBILE GERAL -->
    <meta name="format-detection" content="telephone=no">

    <!-- Schema.org JSON-LD — Escritório de Advocacia -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LegalService",
      "name": "CRUZ Advocacia",
      "alternateName": "Cruz Advogados Associados",
      "url": "https://www.advogadodefesa.com.br",
      "logo": "https://www.advogadodefesa.com.br/src/img/LOGO.png",
      "image": "https://www.advogadodefesa.com.br/src/img/CRUZ_SOCIAL_SITE.png",
      "telephone": "+554732731422",
      "email": "mcruz.advogados@gmail.com",
      "description": "Escritório de advocacia referência em Jaraguá do Sul/SC com +4.000 clientes atendidos e R$12,5 milhões recuperados. Especialistas em Direito Trabalhista, Previdenciário, Civil, Bancário e Criminal.",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Rua Ângelo Schiochet, 280, Sala 3, Centro",
        "addressLocality": "Jaraguá do Sul",
        "addressRegion": "SC",
        "postalCode": "89251-520",
        "addressCountry": "BR"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": -26.4939913,
        "longitude": -49.0811204
      },
      "areaServed": { "@type": "City", "name": "Jaraguá do Sul" },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
          "opens": "08:00",
          "closes": "17:00"
        }
      ],
      "sameAs": [
        "https://www.instagram.com/advogado.defesa",
        "https://www.facebook.com/cruzcop"
      ],
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.8",
        "reviewCount": "22"
      }
    }
    </script>

    <!-- Font Awesome Icons — defer para não bloquear renderização -->
    <script defer src="https://kit.fontawesome.com/b2c3af1d96.js" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="./src/css/style.css?id=<?php echo $refreshkey; ?>" />

    <!-- CSS RESPONSIVOS -->
    <link rel="stylesheet" type="text/css" href="./src/css/1630.css?id=<?php echo $refreshkey; ?>" />
    <link rel="stylesheet" type="text/css" href="./src/css/1536.css?id=<?php echo $refreshkey; ?>" />
    <link rel="stylesheet" type="text/css" href="./src/css/1280.css?id=<?php echo $refreshkey; ?>" />
    <link rel="stylesheet" type="text/css" href="./src/css/1024.css?id=<?php echo $refreshkey; ?>" />
    <link rel="stylesheet" type="text/css" href="./src/css/768.css?id=<?php echo $refreshkey; ?>" />
    <link rel="stylesheet" type="text/css" href="./src/css/640.css?id=<?php echo $refreshkey; ?>" />
    <link rel="stylesheet" type="text/css" href="./src/css/430.css?id=<?php echo $refreshkey; ?>" />

</head>

<body oncontextmenu="return false" ondragstart="return false" onselectstart="return false" class="<?php echo $dark_mode ?>">

    <!-- AUTOLOAD S7VEN -->
    <?php
        include('./autoload_seven.php');
    ?>  


    <div class="whatsapp">
        <i class="fa-brands fa-whatsapp"></i>
    </div>



    <header id="header" class="">
        <div class="header_left">
            <a href="#section_home"></a>
            <img src="./src/img/LOGO.png" alt="CRUZ Advocacia — Jaraguá do Sul SC" class="header_logo" width="180" height="60">
        </div>
        <div class="header_right">    
            <a class="nav_standard" href="#section_home" data-target="section_home" id="ahref_home" onclick="closeMobileMenu()">Home</a>
            <a class="nav_standard" href="#section_sobre" data-target="section_sobre" id="ahref_sobre" onclick="closeMobileMenu()">Sobre nós</a>
            <a class="nav_standard" href="#section_especialidades" data-target="section_especialidades" id="ahref_especialidades" onclick="closeMobileMenu()">Especialidades</a>
            <a class="nav_standard" href="#section_experiencia" data-target="section_experiencia" id="ahref_experiencias" onclick="closeMobileMenu()">Experiência Profissional</a>
            <a class="nav_standard" href="#section_contatos" data-target="section_contatos" id="ahref_contatos" onclick="closeMobileMenu()">Contatos</a>
            <a class="nav_standard" href="#section_endereco" data-target="section_endereco" id="ahref_endereco" onclick="closeMobileMenu()">Como chegar</a>
            <a class="nav_button" href="https://mpago.la/2Zmfvuf"  onclick="closeMobileMenu()">Consulta Direta com Advogado</a>

            
        </div>
        <div class="mobile_menu" id="mobile_menu" onclick="openMobileMenu(this)">
            <i class="fa-solid fa-bars"></i>
            <i class="fa-solid fa-xmark"></i>
        </div>
    </header>



    
    <!-- SECTION HOME -->
    <section class="section_home" id="section_home">
        
        <div class="home_box">
            <h1>Soluções jurídicas completas: excelência e dedicação em todas as áreas do Direito.</h1>
            <h4>Buscar os seus direitos é o nosso trabalho e a nossa missão através da excelência e dedicação dos nossos advogados especialistas em:</h4>
            <h5>
            • Direito Trabalhista <br>
            • Direito Previdenciário <br>
            • Direito Civil e Família <br>
            • Direito Bancário <br>
            • Direito Criminal <br>
            • Direito do Consumidor Imobiliário <br>
            </h5>

            <a class="btn_home" href="https://mpago.la/2Zmfvuf">
                <h4>Falar com um advogado</h4>
            </a>
        </div>

        <i class="fa-solid fa-angle-down"></i>
        
    </section>


    <!-- SECTION SOBRE -->
    <section class="section_sobre" id="section_sobre">
        <div class="sobre_left">
            <h1>Sobre nós</h1>
            <p>
                <span>CRUZ Advogados Associados</span> é um escritório de advocacia referência na região de <span>Jaraguá do Sul/SC</span>, prestando <span>serviços 
                jurídicos de alta performance</span>.
                <br><br>
                Com <span>diferencial no atendimento ao cliente</span>, consultas com advogados especialistas, <span>com valores conforme tabela da OAB</span>;
                <br><br>
                Composto por uma equipe de advogados especialistas e com <span>experiência na representação de processos complexos</span> com soluções jurídicas em diversas áreas 
                como <span>inventário e partilha, trabalhista, benefícios previdenciários do INSS, indenizações e seguros</span>, e <span>realização de atendimento em 
                todo Brasil<span>.
                <br><br>
                Atendimento <span>on-line por WhatsApp</span> e <span>presencial,</span> com plataformas tecnológicas de <span>inteligência artificial</span> 
                desenvolvidas especificamente para defesas em <span>seguros negados, auxílios do INSS negados</span> e <span>reconhecido por ganhar processos e 
                defesa dos seus direitos</span>!
            </p>
        </div>
        <div class="sobre_right">
            <img src="./src/img/sobre.jpg" alt="Equipe CRUZ Advocacia — Advogados especializados em Jaraguá do Sul SC" loading="lazy" width="500" height="400">
        </div>
    </section>


    <!-- SECTION ESPECIALIDADES -->
    <section class="section_especialidades" id="section_especialidades">

        <div class="especialidades_texts">
            <h1>Nossas Especialidades</h1>
            <p>
                Combinamos uma sólida formação técnica com uma visão estratégica para oferecer soluções jurídicas precisas. 
                <br><br>
                Atuamos com foco na excelência e na agilidade, 
                garantindo que nossos clientes tenham suporte especializado nas seguintes áreas:
            </p>
            <br>
            <a class="btn_especialidades" href="https://api.whatsapp.com/send?phone=554732731422&text=Ol%C3%A1,%20gostaria%20de%20falar%20com%20um%20advogado." target="_blank">
                <i class="fa-brands fa-whatsapp"></i>
                <h5>Falar com um Advogado</h5>
            </a>
        </div>

        <div class="cards_grid">

            <div class="card">
                <img src="./src/img/card_1.jpg" alt="Advogado Trabalhista Jaraguá do Sul — demissão, FGTS, horas extras" loading="lazy" width="400" height="250">
                <div class="card_body">
                    <a href="https://api.whatsapp.com/send?phone=554732731422&text=Ol%C3%A1,%20gostaria%20de%20falar%20com%20um%20advogado." target="_blank"></a>
                    <h4>PROCESSO TRABALHISTA</h4>
                    <h5>
                        Demissão por Justa causa, rescisão indireta, danos morais, depósitos FGTS, assédio moral, assédio sexual, horas extras, 
                        trabalho sem registro em carteira, insalubridade, periculosidade.
                    </h5>
                    <div class="btn_card">
                        <i class="fa-brands fa-whatsapp"></i>
                        <h5>Falar com um Advogado</h5>
                    </div>
                </div>
            </div>
            <div class="card">
                <img src="./src/img/card_2.jpg" alt="Advogado Previdenciário Jaraguá do Sul — aposentadoria, INSS, BPC LOAS" loading="lazy" width="400" height="250">
                <div class="card_body">
                    <a href="https://api.whatsapp.com/send?phone=554732731422&text=Ol%C3%A1,%20gostaria%20de%20falar%20com%20um%20advogado." target="_blank"></a>
                    <h4>PROCESSO PREVIDENCIARIO</h4>
                    <h5>
                        Aposentadorias, BPC LOAS benefício assistencial para deficientes e idosos, auxílios-doença e auxílio acidente, 
                        auxílios para autistas, benefícios por incapacidade.
                    </h5>
                    <div class="btn_card">
                        <i class="fa-brands fa-whatsapp"></i>
                        <h5>Falar com um Advogado</h5>
                    </div>
                </div>
            </div>
            <div class="card">
                <img src="./src/img/card_3.jpg" alt="Advogado Civil e Família Jaraguá do Sul — inventário, divórcio, guarda" loading="lazy" width="400" height="250">
                <div class="card_body">
                    <a href="https://api.whatsapp.com/send?phone=554732731422&text=Ol%C3%A1,%20gostaria%20de%20falar%20com%20um%20advogado." target="_blank"></a>
                    <h4>PROCESSO CIVIL E FAMÍLIA</h4>
                    <h5>
                        inventário, divórcio e partilha, guarda e pensão alimentícia cobranças, revisão de contratos danos morais, usucapião.
                    </h5>
                    <div class="btn_card">
                        <i class="fa-brands fa-whatsapp"></i>
                        <h5>Falar com um Advogado</h5>
                    </div>
                </div>
            </div>
            <div class="card">
                <img src="./src/img/card_4.jpg" alt="Advogado Bancário Jaraguá do Sul — juros abusivos, seguros negados" loading="lazy" width="400" height="250">
                <div class="card_body">
                    <a href="https://api.whatsapp.com/send?phone=554732731422&text=Ol%C3%A1,%20gostaria%20de%20falar%20com%20um%20advogado." target="_blank"></a>
                    <h4>PROCESSOS BANCARIOS</h4>
                    <h5>
                        Juros abusivos, revisão de contrato bancário, empréstimos não contratados, descontos indevidos, descontos de RMC, 
                        busca e apreensão de veículo, cobrança de seguros negados, atraso na entrega de imóvel, bens em leilão.
                    </h5>
                    <div class="btn_card">
                        <i class="fa-brands fa-whatsapp"></i>
                        <h5>Falar com um Advogado</h5>
                    </div>
                </div>
            </div>
            <div class="card">
                <img src="./src/img/card_5.jpg" alt="Advogado Criminal Jaraguá do Sul — habeas corpus, júri, violência doméstica" loading="lazy" width="400" height="250">
                <div class="card_body">
                    <a href="https://api.whatsapp.com/send?phone=554732731422&text=Ol%C3%A1,%20gostaria%20de%20falar%20com%20um%20advogado." target="_blank"></a>
                    <h4>PROCESSO CRIMINAL</h4>
                    <h5>
                        Tráfico de Drogas Pedidos de Liberdades Habeas Corpus Tribunal do Juri Defesas de Detentos Violência doméstica.
                    </h5>
                    <div class="btn_card">
                        <i class="fa-brands fa-whatsapp"></i>
                        <h5>Falar com um Advogado</h5>
                    </div>
                </div>
            </div>
            <div class="card">
                <img src="./src/img/card_6.jpg" alt="Advogado do Consumidor Jaraguá do Sul — cobranças indevidas, danos morais" loading="lazy" width="400" height="250">
                <div class="card_body">
                    <a href="https://api.whatsapp.com/send?phone=554732731422&text=Ol%C3%A1,%20gostaria%20de%20falar%20com%20um%20advogado." target="_blank"></a>
                    <h4>PROCESSOS CONSUMIDOR</h4>
                    <h5>
                        Cobranças indevidas, bens e serviços com defeitos e vícios ressarcimento devolução danos morais e materiais.
                    </h5>
                    <div class="btn_card">
                        <i class="fa-brands fa-whatsapp"></i>
                        <h5>Falar com um Advogado</h5>
                    </div>
                </div>
            </div>

        </div>

    </section>




    <!-- BANNER -->
    <div class="banner">
        <h2>
            Soluções Jurídicas apresentada por Especialistas, para defesa de seu direito, em atendimento rápido e on-line, com condições especiais para você 
            também vencer ao processo, como milhares de clientes do nosso escritório de advocacia.
        </h2>
    </div>





    <!-- SECTION EXPERIENCIA -->
    <section class="section_experiencia" id="section_experiencia">

        <div class="experiencia_left">
            <h1>Experiência Reconhecida</h1>
            <p>
                <span>CRUZ ADVOCACIA, A ASSISTÊNCIA JURÍDICA PERTO DE VOCÊ!!</span>
                <br><br>
                A <span>CRUZ Advogados Associados</span> destaca-se como <span>escritório de advocacia</span> de referência, prestando 
                <span>serviços jurídicos de alta performance</span>. Nosso diferencial reside no atendimento ao cliente, <span>consultas com advogados 
                especialistas</span>;
                <br><br>
                Com equipe, de <span>advogados especializados e experientes</span>, na resolução de processos complexos, <span>soluções jurídicas</span> 
                diversas, <span>processos de inventário e partilha trabalhista, benefícios previdenciários do INSS além de indenizações e seguros</span> 
                com <span>atendimento em todo Brasil com sede em Jaraguá do Sul Santa Catarina</span>.
                <br><br>
                <span>Atendimento on-line por WhatsApp</span> e presencial com utilização de plataformas tecnológicas de inteligência artificial  desenvolvidas 
                especificamente para <span>defesas contra seguros negados e auxílios do INSS negados e muitos processos judiciais ganhos</span>.
            </p>
            <br>
            <div class="exp_infos">
                <div class="exp_info">
                    <h1>+4.000</h1>
                    <h4>clientes atendidos</h4>
                </div>
                <div class="exp_info">
                    <h1>+4.000</h1>
                    <h4>casos solucionados</h4>
                </div>
                <div class="exp_info">
                    <h1>+ R$ 12.500.000</h1>
                    <h4>em valores ganhos a favor de nossos clientes</h4>
                </div>
            </div>
        </div>
        <div class="experiencia_right">
            <img src="./src/img/experiencia.jpeg" alt="Experiência reconhecida — CRUZ Advocacia Jaraguá do Sul" loading="lazy" width="500" height="400">
        </div>

    </section>



    <!-- SECTION CONTATOS -->
    <section class="section_contatos" id="section_contatos">

        <div class="formulario">

            <div class="form_header">
                <i class="fa-brands fa-jxl"></i>
                <h4>Preencha o formulário abaixo e entraremos em contato com você.</h4>
            </div>
            <div class="form_body">
                <input type="text" placeholder="Seu melhor e-mail" autocomplete="off">
                <input type="text" placeholder="Seu nome completo" autocomplete="off">
                <input type="text" placeholder="Seu contato com DDD" autocomplete="off">
                <input type="text" placeholder="Assunto do contato" autocomplete="off">
                <textarea name="" id="" placeholder="Mensagem.." autocomplete="off"></textarea>
                <br>
                <h5 class="form_info">Após o envio deste formulário, nossa equipe analisará o seu pedido e entrará em contato!</h5>
                <div class="btn_enviar_form">
                    <h5>ENVIAR FORMULÁRIO</h5>
                </div>
            </div>

        </div>

        <div class="adicionais">

            <h2>Demais Opções</h2>

            <div class="btn_adicional">
                <i class="fa-solid fa-handshake" style="--var:#1a72ff"></i>
                <h4>Trabalhe Conosco</h4>
                <div class="adicional_bottom">
                    <h5>Preencha o formulário e faça parte da equipe do nosso escritório de advocacia.</h5>
                    <a class="btn_action" style="--var:#1a72ff" href="https://forms.gle/ZsPiUKxkwDZ5iHDa7" target="_blank">
                        <h4>PREENCHER FORMULÁRIO</h4>
                    </a>
                </div>
            </div>

            <div class="btn_adicional">
                <i class="fa-solid fa-magnifying-glass" style="--var:#9E00FF"></i>
                <h4>Consultar Processo Judicial</h4>
                <div class="adicional_bottom">
                    <h5>Consulte aqui um processo através do número do processo.</h5>
                    <a class="btn_action" style="--var:#9E00FF" href="https://portaldeservicos.pdpj.jus.br/consulta" target="_blank">
                        <h4>CONSULTAR PROCESSO</h4>
                    </a>
                </div>
            </div>

            <div class="btn_adicional">
                <i class="fa-brands fa-whatsapp" style="--var:#1ea73c"></i>
                <h4>Falar com nossa equipe</h4>
                <div class="adicional_bottom">
                    <h5>Acesse aqui nosso atendimento on-line via whatsapp.</h5>
                    <a class="btn_action" style="--var:#1ea73c" href="https://api.whatsapp.com/send?phone=554732731422&text=Ol%C3%A1,%20gostaria%20de%20falar%20com%20um%20advogado." target="_blank">
                        <h4>CONVERSAR NO WHATSAPP</h4>
                    </a>
                </div>
            </div>

        </div>

    </section>




    <!-- SECTION COMO CHEGAR -->
    <section class="section_endereco" id="section_endereco">
        <div class="endereco_left">
            <h1>Nosso endereço</h1>
            <p>
                Rua Ângelo Schiochet, 280, Sala 3, Centro
                <br>
                Jaraguá do Sul/SC 
                <br>
                CEP 89251-520
                <br>
                (Próximo ao Club Beira Rio)
            </p>

            <br>

            <div class="btn_mapa">
                <i class="fa-solid fa-map-location-dot" style="--var:#1ea73c"></i>
                <h4>Abrir localização no mapa</h4>
                <div class="mapa_bottom">
                    <h5>Acesse a localização pelo maps ou seu App de mapa padrão.</h5>
                    <a class="btn_action" style="--var:#1ea73c" href="https://www.google.com/maps/place/R.+Ângelo+Schiochet,+280+-+Centro,+Jaraguá+do+Sul+-+SC,+89251-520/@-26.4939913,-49.0811204,1005m/data=!3m2!1e3!4b1!4m6!3m5!1s0x94de951e064c3f9f:0x5c019982d097b31a!8m2!3d-26.4939913!4d-49.0811204!16s%2Fg%2F11c5n4nqtq?entry=ttu&g_ep=EgoyMDI2MDIxNi4wIKXMDSoASAFQAw%3D%3D" target="_blank">
                        <h4>ABRIR MAPA</h4>
                    </a>
                </div>
            </div>

        </div>
        <div class="endereco_right">
            <div class="box_map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4375.174830857191!2d-49.081120399999996!3d-26.4939913!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94de951e064c3f9f%3A0x5c019982d097b31a!2sR.%20%C3%82ngelo%20Schiochet%2C%20280%20-%20Centro%2C%20Jaragu%C3%A1%20do%20Sul%20-%20SC%2C%2089251-520!5e1!3m2!1spt-BR!2sbr!4v1771524245077!5m2!1spt-BR!2sbr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>



    <!-- BANNER DEPOIMENTOS -->
    <div class="banner_depoimentos">
        <h1>Depoimentos de clientes satisfeitos</h1>
        <div class="depoimentos_container">
            <div class="box_image">
                <img src="./src/img/dep_1.png" alt="Depoimento cliente satisfeito CRUZ Advocacia Jaraguá do Sul" loading="lazy">
            </div>
            <div class="box_image">
                <img src="./src/img/dep_2.png" alt="Depoimento cliente satisfeito CRUZ Advocacia Jaraguá do Sul" loading="lazy">
            </div>
            <div class="box_image">
                <img src="./src/img/dep_3.png" alt="Depoimento cliente satisfeito CRUZ Advocacia Jaraguá do Sul" loading="lazy">
            </div>
            <div class="box_image">
                <img src="./src/img/dep_4.png" alt="Depoimento cliente satisfeito CRUZ Advocacia Jaraguá do Sul" loading="lazy">
            </div>
            <div class="box_image">
                <img src="./src/img/dep_5.png" alt="Depoimento cliente satisfeito CRUZ Advocacia Jaraguá do Sul" loading="lazy">
            </div>
            <div class="box_image">
                <img src="./src/img/dep_6.png" alt="Depoimento cliente satisfeito CRUZ Advocacia Jaraguá do Sul" loading="lazy">
            </div>
            <div class="box_image">
                <img src="./src/img/dep_1.png" alt="Depoimento cliente satisfeito CRUZ Advocacia Jaraguá do Sul" loading="lazy">
            </div>
            <div class="box_image">
                <img src="./src/img/dep_2.png" alt="Depoimento cliente satisfeito CRUZ Advocacia Jaraguá do Sul" loading="lazy">
            </div>
        </div>
    </div>




    <footer>
        <a class="topo" href="#section_home">
            <i class="fa-solid fa-angle-up"></i>
            <h5>VOLTAR AO TOPO</h5>
        </a>

        <div class="footer_top">
            <div class="footer_tleft">
                <img src="./src/img/LOGO.png" alt="CRUZ Advocacia" loading="lazy" width="160" height="55">
            </div>
            <div class="footer_tright">
                <a class="btn_footer" href="https://www.facebook.com/cruzcop?mibextid=LQQJ4d" target="_blank" title="Curta nossa página no Facebook">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a class="btn_footer" href="https://www.instagram.com/advogado.defesa" target="_blank" title="Siga-nos no Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a class="btn_footer" href="https://api.whatsapp.com/send?phone=554732731422&text=Ol%C3%A1,%20gostaria%20de%20falar%20com%20um%20advogado." target="_blank" title="Atendimento Whatsapp">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a class="btn_footer" href="https://mpago.la/2Zmfvuf" target="_blank" title="Fale diretamente com um Advogado">
                    <i class="fa-solid fa-scale-balanced"></i>
                </a>
                <a class="btn_footer" href="https://portaldeservicos.pdpj.jus.br/consulta" target="_blank" title="Consultar um processo judicial">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>
                <a class="btn_footer" href="https://www.google.com/maps/place/R.+Ângelo+Schiochet,+280+-+Centro,+Jaraguá+do+Sul+-+SC,+89251-520/@-26.4939913,-49.0811204,1005m/data=!3m2!1e3!4b1!4m6!3m5!1s0x94de951e064c3f9f:0x5c019982d097b31a!8m2!3d-26.4939913!4d-49.0811204!16s%2Fg%2F11c5n4nqtq?entry=ttu&g_ep=EgoyMDI2MDIxNi4wIKXMDSoASAFQAw%3D%3D" target="_blank" title="Como chegar até nosso escritório">
                    <i class="fa-solid fa-map-location-dot"></i>
                </a>
            </div>
        </div>

        <div class="footer_bottom">
            <div class="footer_bleft">
                <h5>CRUZ Advocacia | Advogados. Todos os direitos reservados.</h5>
            </div>
            <div class="footer_bright">
                <h5>Desenvolvido por <a href="https://sevench.com.br" target="_blank">SEVEN Creative House</a></h5>
            </div>
        </div>
    </footer>











    <!-- JS — defer para não bloquear renderização -->
    <script defer src="./src/js/script.js?id=<?php echo $refreshkey; ?>"></script>
    <script defer src="./src/js/IntersectionObserver.js?id=<?php echo $refreshkey; ?>"></script>
    <!-- JQUERY -->
    <script defer src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- JQUERY MASK PLUGIN -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>

        document.querySelector('body').style.overflowY = "scroll";

        // ALTERA O HEADER AO ROLAR A TELA
        $(window).scroll(function(){
            var scroll = $(window).scrollTop();
            if(scroll >= 400){
                document.getElementById('header').classList.add('sticky');
            } else {
                document.getElementById('header').classList.remove('sticky');
            }
        })

    </script>
</body>
</html>
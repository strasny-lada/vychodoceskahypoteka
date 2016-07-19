<!DOCTYPE html>
<html lang="cs">
	<head>
		<meta charset="utf-8">
		<?php include_http_metas() ?>
		<?php include_title() ?>
		<?php include_metas() ?>
		<meta property="og:title" content="Východočeská hypotéka" />
		<meta property="og:type" content="website" />
		<meta property="og:site_name" content="Východočeská hypotéka" />
		<meta property="og:url" content="<?php echo 'http://'.$_SERVER['HTTP_HOST'] ?>" />
		<meta property="og:image" content="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/img/header.jpg' ?>" />
		<meta property="og:description" content="" />
        <link rel="icon" type="image/png" href="/image.png">
		<?php include_stylesheets() ?>
	</head>
	<body<?php echo ($sf_request->getAttribute('body_id') ? ' id="'.$sf_request->getAttribute('body_id').'"' : '') ?><?php echo ($sf_request->getAttribute('body_class') ? ' class="'.$sf_request->getAttribute('body_class').'"' : '') ?>>
        <div class="container">
            <header class="header--top">
                <div class="header__inner"><a href="#" class="logo">Východočeská<span>hypotéka</span></a><a href="#" class="nav--mobile"><span class="line line--1"></span><span class="line line--2"></span><span class="line line--3"></span><span class="text">Menu</span></a>
                    <nav class="nav nav--top">
                        <ul class="nav--top__list">
                            <li class="nav--top__list__item"><a href="#" class="nav--top__list__item__link">Nový úvěr<span class="nav--top__list__item__link__moto">Kupuji nemovitost nebo rekonstruuji</span></a></li>
                            <li class="nav--top__list__item"><a href="#" class="nav--top__list__item__link">Mám úvěr<span class="nav--top__list__item__link__moto">Refinancuji</span></a></li>
                            <li class="nav--top__list__item"><a href="#" class="nav--top__list__item__link">Kontakt<span class="nav--top__list__item__link__moto">Potřebuji poradit</span></a></li>
                        </ul>
                    </nav>
                </div>
            </header>
		    <?php echo $sf_content ?>
        </div>
		<?php include_javascripts() ?>
	</body>
</html>
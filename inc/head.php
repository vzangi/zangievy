<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><? echo $title; ?></title>
	<? if ( isset ( $description ) ) { ?>
		<meta name="description" content="<? echo $description; ?>">
		<meta property="og:title" content="<? echo $title; ?>">
		<meta property="og:description" content="<? echo $description; ?>">
		<meta property="og:site_name" content="Генеологическое древо">
		<meta property="og:type" content="article">
		<meta property="og:locale" content="ru_RU">
		<meta property="og:image" content="<? echo $ogImage; ?>">
		<meta property="og:url" content="http://vzangi.ru<? echo $url; ?>">
		
		<meta name="twitter:card" content="summary">
		<meta name="twitter:title" content="<? echo $title; ?>">
		<meta name="twitter:description" content="<? echo $description; ?>">
		<meta name="twitter:image" content="http://vzangi.ru<? echo $url; ?>">
	<? } ?>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="/inc/js/jquery.tmpl.js"></script>
	<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' /> 
	<? if ($page == 'main') { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<? } ?>
	<link rel="manifest" href="/inc/zicons/manifest.json">
	<meta name="theme-color" content="#fff">
</head>
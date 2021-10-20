<?

	$url = str_replace("index.php", "", $_SERVER['REDIRECT_URL']);
	
	//По умолчанию показывается главная страница
	$page = "main";
	
	//Подключаем базу данных
	include $_SERVER['DOCUMENT_ROOT']."/inc/connection.php";
	
	//Описание страницы
	$description = "Сервис поиска родственников по генеалогическому древу";
	
	//По умолчанию в заголовке имя сайта
	$title = "Генеалогическое дерево";
	
	$ogImage = "http://vzangi.ru/icon.png";
	
	if ($url != "" && $url != "/") {
		//Разбиваем запрос на части по косой черте
		$parts = preg_split ( '/\//' , $url, -1, PREG_SPLIT_NO_EMPTY );
		include $_SERVER['DOCUMENT_ROOT'].'/inc/urls.php';
	}
		
	//Выводим результат 
	include $_SERVER['DOCUMENT_ROOT']."/inc/page.php";
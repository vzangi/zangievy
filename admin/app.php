<? if ( !isset($_SESSION) ) exit(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>GEODREVO</title>
	<meta charset='utf-8' />
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<link rel='stylesheet' href='/admin/css/main.css?q=2' />
	<link rel='stylesheet' href='/admin/css/ionicons-2.0.1/css/ionicons.min.css' />
	<link rel="stylesheet" href="/admin/css/jquery-ui.css">
	<link rel='stylesheet' href='/admin/css/datepicker.css' />
	<meta name="theme-color" content="#35b733">
	<!--<script src="/admin/js/jquery.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script> 
	-->
	
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

	
	<script src="/admin/js/jquery-ui.js"></script>
	<script src="/admin/js/jquery.tmpl.js"></script>
	<script src="/admin/js/sammy.min.js"></script>
	<script src='/admin/js/guid.js'></script>
	<script src='/admin/js/ajaxupload.js'></script>
	
	<script src="/admin/js/api.js?v=11"></script>
	<script src="/admin/js/app.js?v=5"></script>
</head>
<body>
	<div class='header'>
		<div class='head-right'>
			<a class='user-info'>
				<span class='user-info-name'><? 
					echo $_SESSION['myprofile']['family']. ' ' .$_SESSION['myprofile']['name']; 
				?></span>
				<span class='user-info-role'><? 
					$role = $_SESSION['myprofile']['role']; 
					if ($role == 0) echo 'Суперадминистратор';
					if ($role == 1) echo 'Администратор';
				?></span>
			</a>
			<a href='/admin/logout/' class='logout'>Выйти</a>
		</div>
		<div class='logo'><a href=''>GEODREVO</a></div>
	</div>
	<div class='main-container'>
		<div id='sidebar-left'>
			<ul class="nav nav-list">
				<li class="nav-item-box active">
					<a href="#dashboard" title="Поиск">
						<div class='ion ion-search' style='font-size: 42px;color: #3A75A7;'></div>
						<span class="name">Поиск</span>
						<span class='new-order-count'></span>
					</a>
				</li>
			</ul>
		</div>
		<div id='content-region' class='content-wrap'>
			<div id="header-region" class="header-wrap"></div>
			<div id="pages-region" class="pages-wrap">
				<div class='pages'></div>
			</div>
		</div>
	</div>
	<div class='loader'>
		<div class='dot d1'></div>
		<div class='dot d2'></div>
		<div class='dot d3'></div>
	</div>
	<div class='printed-content'></div>
</body>
</html>

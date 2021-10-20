﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>Авторизация</title>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="/admin/css/bootstrap.min.css">
	<style>
	body {
	  padding-top: 40px;
	  padding-bottom: 40px;
	  background-color: #fff;
	}

	.form-signin {
	  max-width: 330px;
	  padding: 15px;
	  margin: 0 auto;
	}
	.form-signin .form-signin-heading,
	.form-signin .checkbox {
	  margin-bottom: 10px;
	}
	.form-signin .checkbox {
	  font-weight: normal;
	}
	.form-signin .form-control {
	  position: relative;
	  height: auto;
	  -webkit-box-sizing: border-box;
		 -moz-box-sizing: border-box;
			  box-sizing: border-box;
	  padding: 10px;
	  font-size: 16px;
	}
	.form-signin .form-control:focus {
	  z-index: 2;
	}
	.form-signin input[type="text"] {
	  margin-bottom: -1px;
	  border-bottom-right-radius: 0;
	  border-bottom-left-radius: 0;
	}
	.form-signin input[type="password"] {
	  margin-bottom: 10px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}
	.danger-box{
		font-size: 18px;
		padding: 5px 1px;
	}
	.btn-lg, .btn-group-lg>.btn {
		border-radius: 0;
	}
	</style>

  </head>
<body>
	<div class="container">
		<form class="form-signin" id="loginForm" role="form" action='' method='POST'>
			
			<h2>Авторизация</h2>
			
			<div class="danger-box" style="display: none;">
				<span class="label label-danger">Неверная пара логин-пароль</span>
			</div>
			<input type="text" name='login' class="form-control" placeholder="Логин" required="" autofocus="">
			<input type="password" name='password' class="form-control" placeholder="Пароль" required="">
			<div class="checkbox" style="display: none;">
				<label>
					<input type="checkbox" value="remember-me"> Запомнить меня
				</label>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
		</form>
	</div>

	<script src="/admin/js/jquery.min.js"></script>
    
</body>
</html>
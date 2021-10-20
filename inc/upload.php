<?php
	session_start(); 
	
	error_reporting(0);
	
	if ( !isset($_SESSION['autorized']) ) exit();
	
	function getExtension($filename) {
		return end(explode(".", $filename));
	}
	
	$uploaddir = './upload/'; 
	$n = basename($_FILES['uploadfile']['name']);
	
	$ext = '.'.getExtension( $n );
	
	if ($ext == '.php') exit();
	if ($ext == '.js') exit();
	
	if (isset($_POST['name'])) {
		$n = $_POST['name'].$ext;
		$_FILES['uploadfile']['name'] = $n;
	}
	$file = $uploaddir . $n; 
	 
	 
	 
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
		echo "success ".$n;
	} else {
		echo "error";
	}
?>
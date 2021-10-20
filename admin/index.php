<?
	session_start();
	
	if ( !isset($_SESSION['autorized'])) {
		?>
			<!DOCTYPE html>
			<html><head><meta http-equiv="refresh" content="0; url=./login"></head><body></body></html>
		<?
		exit();
	}
	
	include "app.php";
?>
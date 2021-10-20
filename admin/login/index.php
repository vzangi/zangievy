<?
	session_start();
	
	if ( isset($_SESSION['autorized'])) {
		?>
			<!DOCTYPE html>
			<html><head><meta http-equiv="refresh" content="0; url=/admin/"></head><body></body></html>
		<?
		exit();
	}
	if (isset($_POST)) {
		if (isset($_POST['login']) && isset($_POST['password'])) {
			$l = $_POST['login'];
			$p = $_POST['password'];
			
			include $_SERVER['DOCUMENT_ROOT'].'/inc/connection.php';
			
			$res = mysql_query("SELECT * 
								FROM geo_admin AS user 
								WHERE login = '$l' AND password = '$p'");
			
			if (mysql_num_rows( $res ) > 0) {
				$user = mysql_fetch_array( $res, MYSQL_ASSOC );
				$_SESSION['autorized'] = true;
				unset($user['password']);
				$_SESSION['myprofile'] = $user;
				
				?>
					<!DOCTYPE html>
					<html><head><meta http-equiv="refresh" content="0; url=/admin/"></head><body></body></html>
				<?
				exit();
			}
		}
	}
	include "login.php";
?>

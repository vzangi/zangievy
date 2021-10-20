<?
	session_start();
	
	function validate($txt) {
		if (strlen($txt) > 20) {
			return false;
		}
		if (!preg_match("/^[a-zA-z0-9]+$/i", $txt)) {
			return false;
		}
		return true;
	}
	
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
			
			if (validate($l) && validate($p)) 
			{
				include $_SERVER['DOCUMENT_ROOT'].'/inc/connection.php';
				
				$res = mysqli_query($db, "SELECT * 
									FROM geo_admin AS user 
									WHERE login = '$l' AND password = '$p'");
				
				if (mysqli_num_rows( $res ) > 0) {
					$user = mysqli_fetch_array( $res, MYSQLI_ASSOC );
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
	}
	include "login.php";
?>

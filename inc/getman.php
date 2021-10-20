<?
	if (!isset($_POST['family'])) exit;
	if (!isset($_POST['name'])) exit;
	if (!isset($_POST['fname'])) exit;
	
	$family = trim($_POST['family']);
	$name = trim($_POST['name']);
	$fname  = trim($_POST['fname']);
	
	if ($family == '' && $name == '' && $fname == '') exit;
	
	$where = ' WHERE 1=1 ';
	
	if ($family != '') {
		$where .= "AND family LIKE '$family%' ";
	}
	
	if ($name != '') {
		$where .= "AND name LIKE '$name%' ";
	}
	
	if ($fname != '') {
		$where .= "AND fathername LIKE '$fname%' ";
	}
	
	$query = "SELECT *, (SELECT gf.foto FROM geo_foto AS gf WHERE gf.man = gm.id LIMIT 0,1) AS foto
				FROM geo_man AS gm $where ORDER BY family, name, fathername LIMIT 0,10";
	
	include 'connection.php';
	
	$mans = array();
	
	$res = mysqli_query($db, $query);
	
	if ($res && mysqli_num_rows($res) > 0) {
		while( ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) ) {
			$mans[] = $row;
		}
	}
	
	header('Content-Type: application/json');
	header('Cache-Control: no-store,no-cache,must-revalidate');
	exit( json_encode( $mans ) ); 
?>
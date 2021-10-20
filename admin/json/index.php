<?
	session_start();
	
	//Запрашиваемый адрес
	$url = $_SERVER['REDIRECT_URL']; 
	$method = $_SERVER['REQUEST_METHOD'];
	$query_string = $_SERVER['QUERY_STRING'];
	
	header('Content-Type: application/json');
	header('Cache-Control: no-store,no-cache,must-revalidate');
	//exit( json_encode( $_SERVER ) );

	if ( !isset($_SESSION['autorized'])) {
		exit( json_encode( array("error"=>"not autorized") ) );
	}

	if ($url == '' || $url == '/') {
		exit( json_encode( array("dir"=>"json") ) );
	}
	
	//Разбиваем запрос на части по косой черте
	$parts = preg_split ( '/\//' , $url, -1, PREG_SPLIT_NO_EMPTY );
	
	//exit( json_encode( $parts ) );
	
	if (count($parts) == 0) {
		exit( json_encode( array("error"=>"url not correct") ) );
	}
	
	if ($parts[1] != 'json') {
		exit( json_encode( array("error"=>"first dir must be json") ) );
	}
	
	if (count($parts) == 2) {
		exit( json_encode( array() ) );
	}
	
	$table = $parts[2];
	
	if ($table == 'myprofile') {
		exit( json_encode( $_SESSION['myprofile'] ) );
	}
	
	if (count($parts) == 4) {
		$itemId = $parts[3];
	}
	
	
	if ( !file_exists( $_SERVER['DOCUMENT_ROOT'].'/admin/json/_tables/'.$table.'.php' ) ) {
		exit( json_encode( array("error"=>"config not found") ) );
	}
	
	include $_SERVER['DOCUMENT_ROOT'].'/admin/json/_tables/'.$table.'.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/connection.php';
	
	if ($method == 'GET') {
	
		$hidden_row = array();	//Список скрытых полей
		$array_row = array();	//Список полей-массивов
		
		if ($query_string != '') {
			if (isset($_GET['query'])) {
				$json = str_replace("\\", "", $_GET['query']);
				$q = json_decode( json_decode(json_encode($json)));
				//$q = json_decode( $_GET['query'] );
			}
			$where = "";
			$t = array();
			
			foreach( $q AS $key => $value ) {
				if (is_object($value)) {
					if ($key == 'or') {
						$where .= 'AND (1 != 1 ';
						foreach( $value AS $key2 => $value2 ) {
							foreach( $value2 AS $key3 => $value3 ) {
								if ($key3 == 'like') {
									$where .= "OR `$key2` LIKE '%$value3%' ";
								}
								if ($key3 == 'greatorequal') {
									$where .= "OR `$key2` >= '$value3' ";
								}
								if ($key3 == 'equal') {
									$where .= "OR `$key2` = '$value3' ";
								}
								if ($key3 == 'noequal') {
									$where .= "OR `$key2` != '$value3' ";
								}
							}
						}
						$where .= ')';
					} else {
						foreach( $value AS $key2 => $value2 ) {
							if ($key2 == 'equal') {
								$where .= "AND `$key` = '$value2' ";
							}
							if ($key2 == 'great') {
								$where .= "AND `$key` > '$value2' ";
							}
							if ($key2 == 'less') {
								$where .= "AND `$key` < '$value2' ";
							}
							if ($key2 == 'greatorequal') {
								$where .= "AND `$key` >= '$value2' ";
							}
							if ($key2 == 'lessorequal') {
								$where .= "AND `$key` <= '$value2' ";
							}
							if ($key2 == 'like') {
								$where .= "AND `$key` LIKE '%$value2%' ";
							}
							if ($key2 == 'likebegin') {
								$where .= "AND `$key` LIKE '$value2%' ";
							}
						}
					}
				} else {
					$where .= "AND `$key` = '$value' ";
				}
			}
		}
		
		//Учет особенностей полей таблицы (скрытые поля, поля-массивы)
		//Берем их из конфигурации
		foreach( $config AS $key => $value ) {
			if ( isset( $value['hidden'] ) && $value['hidden'] == true) {
				$hidden_row[] = $key;
			}
			if ( isset( $value['type'] ) && $value['type'] == 'array' ) {
				$array_row[] = $key;
			}
		}
		
		if ( isset($itemId) ) {
			$query = "SELECT * FROM `$table` WHERE id = $itemId $where";
			
			$response = mysqli_query($db, $query);
			if (mysqli_num_rows($response) != 0) {
				$item = mysqli_fetch_array($response, MYSQLI_ASSOC);
				$item = normalize($array_row, $hidden_row, $item);
				exit( json_encode( $item ) );
			} 
		} else {
			$query = "SELECT * FROM `$table` WHERE 1 = 1 $where";
			$response = mysqli_query($db, $query);
			$items = array();
			if (mysqli_num_rows($response) != 0) {
				while ( ($row = mysqli_fetch_array($response, MYSQLI_ASSOC)) !== false ) {
					$items[] = normalize($array_row, $hidden_row, $row);
				}
			}
			
			exit( json_encode( $items ) );
		}
	}
	if ($method == 'POST') {	//Добавление
		
		$array_row = array();	//Список полей-массивов
		
		//Учет особенностей полей таблицы (поля-массивы)
		//Берем их из конфигурации
		foreach( $config AS $key => $value ) {
			if ( isset( $value['type'] ) && $value['type'] == 'array' ) {
				$array_row[ $key ] = $key;
			}
		}
		
		$values = "NULL";
		$keys = "id";
		
		foreach( $config AS $key => $value ) {
			if ( $key == "id" ) continue;
			
			$keys .= ',`'.$key.'`';
			if (isset( $array_row[ $key ] )) {
				if (isset($_POST[$key])) {
					$values .= ',\''.serialize( $_POST[$key] ).'\'';
				} else $values .= ',\'a:0:{}\'';
			} else {
				$values .= ',\''.$_POST[$key].'\'';
			}
		}
		
		$query = "INSERT INTO `$table` ($keys) VALUES ($values)";
		$res = mysqli_query($db, $query);
		if ($res) {
			$cid = mysqli_insert_id();
			exit ( json_encode(array("id" => $cid, "status" => 200)) );
		} else {
			exit ( json_encode(array("status" => 300, "message" => "Not inserted", "query" => $query)) );
		}
	}
	if ($method == 'PUT') {	//Изменение
		
		$_PUT = array(); 
		if($_SERVER['REQUEST_METHOD'] == 'PUT') { 
		  $putdata = file_get_contents('php://input'); 
		  $exploded = explode('&', $putdata);  
		 
		  foreach($exploded as $pair) { 
			$item = explode('=', $pair); 
			if(count($item) == 2) { 
			  $k = urldecode($item[0]);
			  $v = urldecode($item[1]);
			  if (strpos($k, '[') !== false) {
				$pos = strpos($k, '[');
				$pos2 = strpos($k, ']');
				$f = substr($k, 0, $pos);
				$index = substr($k, $pos+1, $pos2-$pos-1);
				$f2 = substr($k, $pos2+2, strlen($k)-$pos2-3);
				// phones[0][type]
				// f = phones, index = 0, f2 = type
				if (!isset($_PUT[$f])) {
					$_PUT[$f] = array();
				}
				if (count($_PUT[$f]) < $index*1 + 1) {
					$_PUT[$f][] = array();
				}
				$_PUT[$f][$index][$f2] = $v;
			  } else {
				$_PUT[$k] = $v;
			  }
			} 
		  } 
		}
		
		if (!isset($_PUT['id'])) {
			exit ( json_encode(array("status" => 300, "message" => "Id not found", "put" => $_PUT)) );
		}
		
		$array_row = array();	//Список полей-массивов
		
		//Учет особенностей полей таблицы (поля-массивы)
		//Берем их из конфигурации
		foreach( $config AS $key => $value ) {
			if ( isset( $value['type'] ) && $value['type'] == 'array' ) {
				$array_row[ $key ] = $key;
			}
		}
		
		$id = $_PUT['id'];
		
		$sets = "";
		$t = "";
		foreach( $config AS $key => $value ) {
			
			if ( $key == "id" ) continue;
			
			if ( isset( $_PUT[ $key ] )) {
				if (isset( $array_row[ $key ] )) {
					//$t .= "$key = ".serialize( $_PUT[ $key ] );
					$sets .= '`'.$key.'` = \''.serialize( $_PUT[ $key ] ).'\',';
				} else {
					$sets .= '`'.$key.'` = \''.$_PUT[ $key ].'\',';
				}
			} else {
				$t .= "$key ";
			}
		}
		
		$sets = substr( $sets, 0, strlen($sets) - 1 );
		
		//exit ( json_encode( $sets ) );
		
		$res = mysqli_query($db, "UPDATE `$table` SET $sets WHERE id = $id");
		
		if ($res) {
			$cid = mysqli_insert_id();
			exit ( json_encode(array("status" => 200, "sets" => $t, "put" => $_PUT)) );
		} else {
			exit ( json_encode(array("status" => 300, "message" => "Not updated")) );
		}
	}
	if ($method == 'DELETE') {	//Удаление
		
		if (!isset($itemId)) {
			exit ( json_encode(array("status" => 300, "message" => "Id not found")) );
		}
		
		$res = mysqli_query($db, "DELETE FROM `$table` WHERE id = $itemId");
		
		if ($res) {
			$cid = mysqli_insert_id();
			exit ( json_encode(array("status" => 200)) );
		} else {
			exit ( json_encode(array("status" => 300, "message" => "Not deleted")) );
		}
	}
	
	function normalize($array_row, $hidden_row, $row) {
		for ($i = 0; $i < count($hidden_row); $i++) {
			unset ( $row[ $hidden_row[$i] ] );
		}
		for ($i = 0; $i < count($array_row); $i++) {
			$row[$array_row[$i]] = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $row[$array_row[$i]]);
			$row[$array_row[$i]] = unserialize($row[$array_row[$i]]);
		}
		return $row;
	}
?>
<?
	$config = array( 
		"id" => array(
			"type" => "integer",
			"primary" => true
		),
		"fio" => array(
			"type" => "varchar",
			"length" => 100
		),
		"password" => array(
			"type" => "varchar",
			"length" => 100,
			"hidden" => true
		),
		"regdate" => array(
			"type" => "varchar",
			"length" => 100
		),
		"phone" => array(
			"type" => "varchar",
			"length" => 100
		),
		"active" => array(
			"type" => "integer"
		)
	);
?>
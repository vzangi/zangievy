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
		"phone" => array(
			"type" => "varchar",
			"length" => 100
		),
		"theme" => array(
			"type" => "integer"
		),
		"message" => array(
			"type" => "varchar",
			"length" => 100
		),
		"active" => array(
			"type" => "integer"
		),
		"pubdate" => array(
			"type" => "varchar",
			"length" => 20
		)
	);
?>
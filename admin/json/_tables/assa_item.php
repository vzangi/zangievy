<?
	$config = array( 
		"id" => array(
			"type" => "integer",
			"primary" => true
		),
		"name" => array(
			"type" => "varchar",
			"length" => 100
		),
		"weight" => array(
			"type" => "varchar",
			"length" => 100
		),
		"description" => array(
			"type" => "varchar",
			"length" => 100
		),
		"price" => array(
			"type" => "integer"
		),
		"category" => array(
			"type" => "integer"
		),
		"img" => array(
			"type" => "varchar",
			"length" => 100
		),
		"active" => array(
			"type" => "integer"
		),
		"sort" => array(
			"type" => "integer"
		)
	);
?>
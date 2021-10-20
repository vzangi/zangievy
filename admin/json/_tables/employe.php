<?
	$config = array( 
		"id" => array(
			"type" => "integer",
			"primary" => true
		),
		"login" => array(
			"type" => "varchar",
			"length" => 100
		),
		"password" => array(
			"type" => "varchar",
			"length" => 100,
			"hidden" => true
		),
		"family" => array(
			"type" => "varchar",
			"length" => 100
		),
		"name" => array(
			"type" => "varchar",
			"length" => 100
		),
		"role" => array(
			"type" => "integer"
		)
	);
?>
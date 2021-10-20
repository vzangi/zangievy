<?
	$config = array( 
		"id" => array(
			"type" => "integer",
			"primary" => true
		),
		"parentgroup" => array(
			"type" => "integer"
		),
		"name" => array(
			"type" => "varchar",
			"length" => 100
		),
		"img" => array(
			"type" => "varchar",
			"length" => 100
		),
		"showonpanel" => array(
			"type" => "integer"
		),
		"sort" => array(
			"type" => "integer"
		),
		"link" => array(
			"type" => "varchar",
			"length" => 100
		),
		"active" => array(
			"type" => "integer"
		),
		"skidka" => array(
			"type" => "integer"
		)
	);
?>
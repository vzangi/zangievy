<?
	$config = array( 
		"id" => array(
			"type" => "integer",
			"primary" => true
		),
		"family" => array(
			"type" => "varchar",
			"length" => 100
		),
		"name" => array(
			"type" => "varchar",
			"length" => 100
		),
		"fathername" => array(
			"type" => "varchar",
			"length" => 100
		),
		"father" => array(
			"type" => "integer"
		),
		"mother" => array(
			"type" => "integer"
		),
		"birthdate" => array(
			"type" => "varchar",
			"length" => 10
		),
		"deathdate" => array(
			"type" => "varchar",
			"length" => 10
		),
		"pol" => array(
			"type" => "integer"
		),
		"description" => array(
			"type" => "varchar",
			"length" => 1000
		),
		"sort" => array(
			"type" => "integer"
		)
	);
?>
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
		"description" => array(
			"type" => "varchar",
			"length" => 100
		),
		"price" => array(
			"type" => "integer"
		),
		"smalldesc" => array(
			"type" => "varchar",
			"length" => 100
		),
		"rootgroup" => array(
			"type" => "integer"
		),
		"currentgroup" => array(
			"type" => "integer"
		),
		"img" => array(
			"type" => "varchar",
			"length" => 100
		),
		"recommend" => array(
			"type" => "integer"
		),
		"active" => array(
			"type" => "integer"
		),
		"popularmale" => array(
			"type" => "integer"
		),
		"popularfemale" => array(
			"type" => "integer"
		),
		"popular13" => array(
			"type" => "integer"
		),
		"popular1317" => array(
			"type" => "integer"
		),
		"popular1820" => array(
			"type" => "integer"
		),
		"popular21" => array(
			"type" => "integer"
		),
		"popular" => array(
			"type" => "integer"
		),
		"rating" => array(
			"type" => "integer"
		)
	);
?>
<?
	$config = array( 
		"id" => array(
			"type" => "integer",
			"primary" => true
		),
		"title" => array(
			"type" => "varchar",
			"length" => 100
		),
		"pubdate" => array(
			"type" => "varchar",
			"length" => 10
		),
		"img" => array(
			"type" => "varchar",
			"length" => 100
		),
		"img_small" => array(
			"type" => "varchar",
			"length" => 100
		),
		"content" => array(
			"type" => "text"
		),
		"active" => array(
			"type" => "integer"
		),
		"prevu" => array(
			"type" => "varchar",
			"length" => 100
		),
		"showonmain" => array(
			"type" => "integer"
		),
		"link" => array(
			"type" => "varchar",
			"length" => 100
		)
	);
?>
<?
	//Роуты
	$first = $parts[0];
	$pcount = count($parts);
	 
	if ($first == 'm' && $pcount == 2) {
		$manId = $parts[1];
		
		include 'man.php';
		
		$currentMan = new Man($manId, $db);
		
		if ($currentMan->man) {
			$page = 'man-old';
			
			$father = $currentMan->getFather();
			$mother = $currentMan->getMother();
			
			$partners = $currentMan->getPartners();
			
			$allChilds = array();
			
			foreach($partners AS $partner) {
				$childs = $partner->getChilds( $currentMan );
				$allChilds[] = $childs;
			}
			
			$title = $title . " | " . $currentMan->man['family'].' '.$currentMan->man['name'].' '.$currentMan->man['fathername'];
			if ($currentMan->man['description'] != ''){
				$description = $currentMan->man['description'];
			}
			if (count($currentMan->manFotos) > 0) {
				$ogImage = "http://vzangi.ru" . $currentMan->manFotos[0]['foto'];
			}
		}
	} 
		
	if ($first == 'man' && $pcount == 2) {
		$manId = $parts[1];
		
		include 'man.php';
		
		$currentMan = new Man($manId, $db);
		
		$parents = array();
		
		$fathers[] = $currentMan->getFather();
		//Загружаем отца и дедов в массив
		while ($fathers[count($fathers)-1] !== false) {
			$fathers[] = $fathers[count($fathers)-1]->getFather();
		}
		
		if ($currentMan->man) {
			$page = 'man';
			
			$title = $title . " | " . $currentMan->man['family'].' '.$currentMan->man['name'].' '.$currentMan->man['fathername'];
			
			if ($currentMan->man['description'] != ''){
				$description = $currentMan->man['description'];
			}
			if (count($currentMan->manFotos) > 0) {
				$ogImage = "http://vzangi.ru" . $currentMan->manFotos[0]['foto'];
			}
		}
	}
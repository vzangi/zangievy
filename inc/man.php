<?
class Man {
	public $man;
	public $manFotos;
	private $db;
	
	function __construct($manId, $db) {
		$this->db = $db;
		
		$query = "SELECT * FROM geo_man WHERE id = $manId";
		
		$res = mysqli_query($this->db, $query);
		
		if ($res && mysqli_num_rows($res) == 1) {
			$this->man = mysqli_fetch_array($res, MYSQLI_ASSOC);
			
			$this->manFotos = array();
			
			//Загружаем фото
			$query = "SELECT * FROM geo_foto WHERE man = $manId ORDER BY sort";
			$res = mysqli_query($this->db, $query);
			if ($res && mysqli_num_rows($res) > 0) {
				while ( ($row=mysqli_fetch_array($res,MYSQLI_ASSOC)) ) {
					$this->manFotos[] = $row;
				}
			}
		}
	}
	
	function getFather() {
		
		if ($this->man['father'] == 0) return false;
		
		$father = new Man($this->man['father'], $this->db);
		
		return $father;
		
	}
	
	function getMother() {
		
		if ($this->man['mother'] == 0) return false;
		
		$mother = new Man($this->man['mother'], $this->db);
		
		return $mother;
		
	}
	
	function getPartners(){
		$partners = array();
		
		$query = "SELECT * FROM geo_marrieds 
			WHERE man = ".$this->man['id']." OR woman = ".$this->man['id']." ORDER BY sort";
		
		$res = mysqli_query($this->db, $query);
		if ($res && mysqli_num_rows($res) > 0) {
			
			while ( ($row=mysqli_fetch_array($res,MYSQLI_ASSOC)) ) {
				if ($this->man['pol'] == 0) {
					$partners[] = new Man($row['man'], $this->db);
				} else {
					$partners[] = new Man($row['woman'], $this->db);
				}
				
			}
		}
		
		return $partners;
	}
	
	function getChilds($partner) {
		
		
		$query = "SELECT * FROM geo_man 
			WHERE 
				mother = ".$this->man['id']." AND father = ".$partner->man['id']." OR 
				father = ".$this->man['id']." AND mother = ".$partner->man['id']." ORDER BY sort";
		
		$childs = array();
		
		$res = mysqli_query($this->db, $query);
		if ($res && mysqli_num_rows($res) > 0) {
			while ( ($row=mysqli_fetch_array($res,MYSQLI_ASSOC)) ) {
				$childs[] = new Man($row['id'], $this->db);
			}
		}
		
		return $childs;
	}
	
}
?>
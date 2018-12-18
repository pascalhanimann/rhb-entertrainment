<?php
	include './php/dbconf.php';
	
	class DB {
		private $pdo;
		
		public function connect() {
			$this->pdo = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME, DB_USER, DB_PASSWORD);
		}
		
		public function get_env_data($way_percent) {
			$rounded = round($way_percent * 2) / 2;
			
			$stmt = $this->pdo->prepare('SELECT `speed`, `temperature`, `elevation` FROM `env_data` WHERE `location` = ?');
			$stmt->execute(array($rounded));
			
			while ($row = $stmt->fetch()) {
				return array(
					'speed' => $row['speed'],
					'temperature' => $row['temperature'],
					'elevation' => $row['elevation']
				);
			}
			
			return null;
		}
	}
	
	$db = new DB();
	$db->connect();
?>
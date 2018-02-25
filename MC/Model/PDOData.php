<?php

/**
* Use PDO
*/

class PDOData
{
	static private $instance = null;
	private $db = null;

	private function __construct($corporation) {

		try {
			$servelName 	= "localhost";
			$databaseName 	= "stockcontrol_" . $corporation;
			$username 		= "root";
			$password 		= "";
			$this->db 		= new PDO("mysql:dbname=$databaseName;host=$servelName", $username, $password);
			$this->setConnectionNames();
		} catch (PDOException $ex) {
			echo 'Connection failed: ' . $ex->getMessage();
		}
	}

	static function getInstance($corporation) {

		if (self::$instance == null) {
			self::$instance = new PDOData($corporation);
		}
		return self::$instance;
	}

	public function setConnectionNames() {
		$this->db->exec("SET names utf8");
	}

	public function selectData($query) {

		$response = array();
		try {
			$stmt = $this->db->prepare($query); 
			$stmt->execute();
			$response = $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {	
        	echo $ex->getMessage(); 
        }
        return $response;
	}

	public function executeData($exec) {

		try {
			$this->db->exec($exec);
			return $this->db->lastInsertId();
		} catch (PDOException $ex) {
	    	echo $ex->getMessage();
	    }
	}
}

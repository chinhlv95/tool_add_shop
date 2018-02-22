<?php

/**
* Use PDO
*/

class PDOData
{
	private $db = null;

	function __construct($corporation) {

		try {
			$servelName 	= "localhost";
			$databaseName 	= "stockcontrol_" . $corporation;
			$username 		= "root";
			$password 		= "";
			$this->db 		= new PDO("mysql:dbname=$databaseName;host=$servelName", $username, $password);
			$this->setConnection();
		} catch(PDOException $ex) {
			echo 'Connection failed: ' . $ex->getMessage();
		}
	}

	public function setConnection() {
		$this->db->exec("SET names utf8");
	}

	public function getConnection() {

		return $this->db;
	}

	public function selectData($query) {

		$response = array();
		try {
			$stmt = $this->db->prepare($query); 
			$stmt->execute();
			$response = $stmt->fetch(PDO::FETCH_OBJ);
        } catch(PDOException $ex) {	
        	echo $ex->getMessage(); 
        }
        return $response;
	}

	public function executeData($exec) {

		try {
			$this->db->exec($exec);
		} catch(PDOException $e) {
	    	echo $e->getMessage();
	    }
	}
}
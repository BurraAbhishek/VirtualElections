<?php
    class Connection
	{
		private $dbms = "mysql";
		private $host = "localhost";
		private $dbname = "virtualelection";
		private $username = "root";
		private $password = "";
		public $conn;
		public function openConnection() {
			try {
				$this->conn = new PDO("$this->dbms:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
				return $this->conn;
			} catch(PDOException $e) {
				echo 'Error: The server refused to connect.';
				echo $e;
			}
		}
		public function closeConnection() {
			$this->conn = null;
		}
	}
?>

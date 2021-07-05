<?php
    class Connection
	{
		private $dbms = "mysql";
		private $host = "localhost";
		private $dbname = "virtualelection";
		private $username = "root";
		private $password = "";
		public $conn;
		public function createDatabase() {
			try{
				$this->conn = new PDO("$this->dbms:host=$this->host", $this->username, $this->password);
				$sql = $this->conn->prepare("CREATE DATABASE IF NOT EXISTS `$this->dbname` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
				$sql->execute();
				$this->conn = null;
				echo "Database $this->dbname created successfully.<br>";
			} catch(Exception $e) {
				echo 'Error: Couldn\'t create the database';
			}
		}
		public function openConnection() {
			try {
				$this->conn = new PDO("$this->dbms:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
				return $this->conn;
			} catch(Exception $e) {
				echo 'Error: The server refused to connect.';
			}
		}
		public function closeConnection() {
			$this->conn = null;
		}
	}
?>

<?php
	/**
	 * Creates a new connection to the database.
	 * 
	 * This connection class has 5 properties:
	 * <ul>
	 * 		<li> $dbms: Refers to the database driver (system) used. </li>
	 * 		<li> $host: Refers to the URL of the webserver. 
	 *               (Values: localhost, IPv4 addresses) </li>
	 * 		<li> $dbname: Refers to the name of the database </li>
	 * 		<li> $username: Refers to the database username </li>
	 * 		<li> $password: Refers to the database password </li>
	 * </ul>
	 * NOTE:
	 * <ul>
	 * 		<li> If you are using object-oriented mysqli instead of PDO, 
	 *               replace PDO with mysqli. </li>
	 * 		<li> If you are using procedural mysqli, replace 
	 *               each line of the code in each function as required </li>
	 * 		<li> The security of the SQL queries depends on the 
	 *               value of the above properties. </li>
	 * </ul>
	 * This class can be used in any application.
	 *
	 * @author Burra Abhishek
	 * @license Apache License, Version 2.0
	 * 
	 */
    class Connection
	{
		private $dbms = "mysql";
		private $host = "localhost";
		private $dbname = "virtualelection23";
		private $username = "root";
		private $password = "";
		public $conn;
		public function createDatabase() {
			try {
				$this->conn = new PDO(
					"$this->dbms:host=$this->host", 
					$this->username, 
					$this->password
				);
				$sql = $this->conn->prepare(
					"CREATE DATABASE IF NOT EXISTS `$this->dbname` 
					DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
				);
				$sql->execute();
				$this->conn = null;
				echo "Database $this->dbname created successfully.<br>";
			} catch(Exception $e) {
				throw new Exception("Couldn't create the database");
			}
		}
		public function openConnection() {
			try {
				$this->conn = new PDO(
					"$this->dbms:host=$this->host;dbname=$this->dbname", 
					$this->username, 
					$this->password
				);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
				return $this->conn;
			} catch(Exception $e) {
				throw new Exception("The server refused to connect");
			}
		}
		public function closeConnection() {
			$this->conn = null;
		}
	}
?>

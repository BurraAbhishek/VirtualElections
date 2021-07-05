<?php
	error_reporting(0);
	session_start();
?>

<?php

	require '../db/dbconfig.php';
	require '../db/tablesconfig.php';

	$tables = new Table();
	$voter_table = $tables->getVoterList();
	$voter = $voter_table["table"];
	$voter_id = $voter_table["id"];
	$voter_name = $voter_table["voter_name"];
	$idno = $voter_table["idproof_value"];
	$idproof = $voter_table["idproof_type"];
	$password = $voter_table["password"];

	$dbconn = new Connection();
	$conn = $dbconn->openConnection();

	try {
		if(isset($_POST['save'])) {
			$pwd = $_POST['cpd1'];
			$citype = $_POST['citype'];
			$cidno = $_POST['cidno'];
			$sql = $conn->prepare("SELECT * FROM $voter WHERE $idproof = :citype AND $idno = :cidno");
			$sql->bindParam(':citype', $citype, PDO::PARAM_STR, 20);
			$sql->bindParam(':cidno', $cidno, PDO::PARAM_STR, 50);
			$sql->execute();
			$userid = $sql->fetchAll();
			foreach($userid as $u){
				$u1 = $u[$idproof];
				$u2 = $u[$idno];
				$u3 = $u[$password];
			}
			if(($citype == $u1) && ($cidno == $u2) && (password_verify($pwd, $u3))) {
				$_SESSION["voterid"] = $u[$voter_id];
				$_SESSION["votername"] = $u[$voter_name];
				echo '<script>window.location.href="check_if_already_voted.php";</script>';
			} else {
				echo '<script>alert("VerificationError: Voter is not registered.");window.location.replace("voter_login.php");</script>';
			}
		}
	}

	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>

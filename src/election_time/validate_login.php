<?php
	error_reporting(0);
	session_set_cookie_params([
		'httponly' => true,
		'samesite' => 'strict',
	]);
	session_start();
?>

<?php

	require_once '../db/dbconfig.php';
	require_once '../db/tablesconfig.php';
	require_once '../controllers/ssl.php';

	$tables = new Table();
	$voter_table = $tables->getVoterList();
	$voter = $voter_table["table"];
	$voter_id = $voter_table["id"];
	$voter_name = $voter_table["voter_name"];
	$idno = $voter_table["idproof_value"];
	$idproof = $voter_table["idproof_type"];
	$password = $voter_table["password"];

	$s = new SecureData();

	$dbconn = new Connection();
	$conn = $dbconn->openConnection();

	try {
		if(isset($_POST['save'])) {
			$pwd = $_POST['cpd1'];
			$citype = $s->encrypt($_POST['citype']);
			$cidno = $s->encrypt($_POST['cidno']);
			$sql = $conn->prepare("SELECT * FROM $voter WHERE $idproof = :citype AND $idno = :cidno");
			$sql->bindParam(':citype', $citype, PDO::PARAM_STR, 128);
			$sql->bindParam(':cidno', $cidno, PDO::PARAM_STR, 256);
			$sql->execute();
			$userid = $sql->fetchAll();
			foreach($userid as $u){
				$u1 = $u[$idproof];
				$u2 = $u[$idno];
				$u3 = $u[$password];
			}
			if(($citype == $u1) && ($cidno == $u2) && (password_verify($pwd, $u3))) {
				$_SESSION["voterid"] = $u[$voter_id];
				$_SESSION["votername"] = $s->decrypt($u[$voter_name]);
				header("location: check_if_already_voted.php");
			} else {
				header("location: votefailed.html");
			}
		}
	}

	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>

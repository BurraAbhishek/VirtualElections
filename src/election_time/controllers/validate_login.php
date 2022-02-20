<?php
	error_reporting(0);

	session_start();
	echo $_SESSION['token'];
?>

<?php

	require_once '../../db/config/dbconfig.php';
	require_once '../../db/config/tablesconfig.php';
	require_once '../../db/controllers/ssl.php';

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
		if(!empty($_POST['token'])) {
			if(hash_equals($_SESSION['token'], $_POST['token'])) {
				if(isset($_POST['save'])) {
					$pwd = $_POST['cpd1'];
					$citype = $s->encrypt($_POST['citype']);
					$cidno = $s->encrypt($_POST['cidno']);
					$sql = $conn->prepare(
						"SELECT * FROM $voter 
						WHERE $idproof = :citype 
						AND $idno = :cidno"
					);
					$sql->bindParam(':citype', $citype, PDO::PARAM_STR, 256);
					$sql->bindParam(':cidno', $cidno, PDO::PARAM_STR, 256);
					$sql->execute();
					$userid = $sql->fetchAll();
					foreach($userid as $u){
						$u1 = $u[$idproof];
						$u2 = $u[$idno];
						$u3 = $u[$password];
					}
					if(
						($citype == $u1) 
						&& ($cidno == $u2) 
						&& (password_verify($pwd, $u3))
					) {
						$_SESSION["voterid"] = $u[$voter_id];
						$_SESSION["votername"] = $s->decrypt($u[$voter_name]);
						$_SESSION["alt"] = $_POST["token"];
						header("location: check_if_already_voted.php");
					} else {
						header("location: ../status/votefailed.html");
					}
				}
			} else {
				header('location: ../../public/oops/corrections_userinput.html');
			}
		} else {
			header('location: ../../public/oops/403.html');
		}
	}

	catch(PDOException $e) {
		header('location: ../../public/oops/503.html');
	}
?>

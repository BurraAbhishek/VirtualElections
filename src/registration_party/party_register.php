<?php
    error_reporting(0);

	require_once '../db/dbconfig.php';
	require_once '../db/tablesconfig.php';
	require_once '../controllers/ssl.php';
	require_once '../controllers/post_validate.php';

	$tables = new Table();
	$party = $tables->getPartyList();
	$party_table = $party["table"];
	$party_name = $party["party_name"];
	$candidate = $party["candidate_name"];
	$idno = $party["idproof_value"];
	$idproof = $party["idproof_type"];
	$dbconn = new Connection();
	$conn = $dbconn->openConnection();
	$crypto = new SecureData();

	try {
		if(isset($_POST['save'])){
			$pname = $crypto->encrypt(validateName(validateDatatype($_POST['pname'], 'string')));
			$cname = $crypto->encrypt(validateName(validateDatatype($_POST['cname'], 'string')));
			$citype =  $crypto->encrypt(validateName(validateDatatype($_POST['citype'], 'string')));
			$cidno =  $crypto->encrypt(validateID(validateDatatype($_POST['cidno'], 'string')));
			$sql = $conn->prepare("INSERT INTO $party_table ($party_name, $candidate, $idno, $idproof) values (:pname,:cname,:cidno, :citype)");
			$sql->bindParam(':pname', $pname, PDO::PARAM_STR, 512);
			$sql->bindParam(':cname', $cname, PDO::PARAM_STR, 512);
			$sql->bindParam(':citype', $citype, PDO::PARAM_STR, 256);
			$sql->bindParam(':cidno', $cidno, PDO::PARAM_STR, 256);
			if($sql->execute()) {
				header("Location: registration_success.html");
			} else {
				echo '<script>alert("CredentialsError: Registration Failed! Please try again.");window.location.href="registration.php";</script>';
			}
		}
	}

	catch(Exception $e)
	{
		if(strcasecmp($e->getMessage(), "Invalid Identity proof") == 0) {
			header("Location: ../tos_mark/corrections_userinput.html");
		}
		elseif(strcasecmp($e->getMessage(), "Invalid name") == 0) {
			header("Location: ../tos_mark/corrections_userinput.html");
		}
		else {
			header("Location: registration.php");
		}
	}

	$conn = null;
?>

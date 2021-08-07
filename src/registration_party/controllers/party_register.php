<?php
    error_reporting(0);

	require_once '../../db/config/dbconfig.php';
	require_once '../../db/config/tablesconfig.php';
	require_once '../../db/controllers/ssl.php';
	require_once '../../db/controllers/post_validate.php';

	try {
		$dbconn = new Connection();
		$conn = $dbconn->openConnection();
	} catch (Exception $e) {
		header('location: ../../public/oops/403.html');
	}

	$tables = new Table();
	$party = $tables->getPartyList();
	$party_table = $party["table"];
	$party_name = $party["party_name"];
	$candidate = $party["candidate_name"];
	$idno = $party["idproof_value"];
	$idproof = $party["idproof_type"];
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
				header("Location: ../status/registration_success.html");
			} else {
				header("Location: ../status/registration_failed.html");
			}
		}
	}

	catch(Exception $e)
	{
		if(strcasecmp($e->getMessage(), "Invalid Identity proof") == 0) {
			header("Location: ../../public/oops/corrections_userinput.html");
		}
		elseif(strcasecmp($e->getMessage(), "Invalid name") == 0) {
			header("Location: ../../public/oops/corrections_userinput.html");
		}
		else {
			header("Location: ../status/registration_failed.html");
		}
	}

	$conn = null;
?>

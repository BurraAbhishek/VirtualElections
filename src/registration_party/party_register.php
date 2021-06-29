<?php

	require '../db/dbconfig.php';
	require '../db/tablesconfig.php';
	require '../controllers/post_validate.php';

	$tables = new Table();
	$party = $tables->getPartyList();
	$dbconn = new Connection();
	$conn = $dbconn->openConnection();

	try {
		if(isset($_POST['save'])){
			$pname = validateName(validateDatatype($_POST['pname'], 'string'));
			$cname = validateName(validateDatatype($_POST['cname'], 'string'));
			$citype =  validateName(validateDatatype($_POST['citype'], 'string'));
			$cidno =  validateID(validateDatatype($_POST['cidno'], 'string'));
			$sql = $conn->prepare("INSERT INTO $party (party_name, candidate, idno, idproof) values (:pname,:cname,:cidno, :citype)");
			$sql->bindParam(':pname',$pname, PDO::PARAM_STR, 100);
			$sql->bindParam(':cname',$cname, PDO::PARAM_STR, 100);
			$sql->bindParam(':citype', $citype, PDO::PARAM_STR, 20);
			$sql->bindParam(':cidno', $cidno, PDO::PARAM_STR, 50);
			if($sql->execute()) {
				echo '<script>window.location.href="registration_success.html";</script>';
			} else {
				echo '<script>alert("CredentialsError: Registration Failed! Please try again.");window.location.href="registration.php";</script>';
			}
		}
	}

	catch(Exception $e)
	{
		if(strcasecmp($e->getMessage(), "Invalid Identity proof") == 0) {
			header("Location: ../tosviolation/violated.html");
		}
		elseif(strcasecmp($e->getMessage(), "Invalid name") == 0) {
			header("Location: ../tosviolation/violated.html");
		}
		else {
			header("Location: registration.php");
		}
	}

	$conn = null;
?>

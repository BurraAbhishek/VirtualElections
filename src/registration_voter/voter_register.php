<?php
	error_reporting(0);

	require_once '../db/dbconfig.php';
	require_once '../db/tablesconfig.php';
	require_once '../controllers/post_validate.php';
	require_once '../controllers/ssl.php';

	$tables = new Table();
	$voter_table = $tables->getVoterList();
	$voter = $voter_table["table"];
	$voter_name = $voter_table["voter_name"];
	$dob = $voter_table["voter_dob"];
	$idno = $voter_table["idproof_value"];
	$idproof = $voter_table["idproof_type"];
	$gender = $voter_table["voter_gender"];
	$password = $voter_table["password"];

	$crypto = new SecureData();

	$dbconn = new Connection();
	$conn = $dbconn->openConnection();

	try {
		if(isset($_POST['save'])) {
			if(($_POST['cpd1']) != ($_POST['cpd2'])) {
				echo '<script>alert("Confirm your password properly");window.location.replace("registration.php");</script>';
			} else {
				$cname = $crypto->encrypt(validateName(validateDatatype($_POST['cname'], 'string')));
				$cdob = $crypto->encrypt(validateDatatype($_POST['cdob'], 'ANY'));
				$citype = $crypto->encrypt(validateName(validateDatatype($_POST['citype'], 'string')));
				$cidno = $crypto->encrypt(validateName(validateDatatype($_POST['cidno'], 'string')));
				$cgender = $crypto->encrypt(validateName(validateDatatype($_POST['cgender'], 'string')));
				$cpd = validateDatatype($_POST['cpd1'], 'ANY');
				$cpd1 = password_hash($cpd, PASSWORD_DEFAULT);
				$sql = $conn->prepare("INSERT INTO $voter ($voter_name, $dob, $idno, $idproof, $gender, $password) values (:cname,:cdob,:cidno,:citype,:cgender,:cpd)");
				$sql->bindParam(':cname', $cname, PDO::PARAM_STR, 256);
				$sql->bindParam(':cdob', $cdob);
				$sql->bindParam(':citype', $citype, PDO::PARAM_STR, 256);
				$sql->bindParam(':cidno', $cidno, PDO::PARAM_STR, 256);
				$sql->bindParam(':cgender', $cgender, PDO::PARAM_STR, 128);
				$sql->bindParam(':cpd', $cpd1);
				if($sql->execute()) {
					echo '<script>window.location.href="registration_success.html";</script>';
				} else {
					echo '<script>alert("CredentialsError: Registration Failed! Please try again.");window.location.href="registration.php";</script>';
				}
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

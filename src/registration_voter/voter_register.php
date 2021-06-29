<?php
	error_reporting(0);

	require '../db/dbconfig.php';
	require '../db/tablesconfig.php';
	require '../controllers/post_validate.php';

	$tables = new Table();
	$voter = $tables->getVoterList();
	$dbconn = new Connection();
	$conn = $dbconn->openConnection();

	try {
		if(isset($_POST['save'])) {
			if(($_POST['cpd1']) != ($_POST['cpd2'])) {
				echo '<script>alert("Confirm your password properly");window.location.replace("registration.php");</script>';
			} else {
				$cname = validateName(validateDatatype($_POST['cname'], 'string'));
				$cdob = validateDatatype($_POST['cdob'], 'ANY');
				$citype = validateName(validateDatatype($_POST['citype'], 'string'));
				$cidno = validateName(validateDatatype($_POST['cidno'], 'string'));
				$cgender = validateName(validateDatatype($_POST['cgender'], 'string'));
				$cpd = validate($_POST['cpd1'], 'ANY');
				$cpd1 = password_hash($cpd, PASSWORD_DEFAULT);
				$sql = $conn->prepare("INSERT INTO $voter (voter_name, dob, idno, idproof, gender, password) values (:cname,:cdob,:cidno,:citype,:cgender,:cpd)");
				$sql->bindParam(':cname', $cname, PDO::PARAM_STR, 100);
				$sql->bindParam(':cdob', $cdob);
				$sql->bindParam(':citype', $citype, PDO::PARAM_STR, 20);
				$sql->bindParam(':cidno', $cidno, PDO::PARAM_STR, 50);
				$sql->bindParam(':cgender', $cgender, PDO::PARAM_STR, 6);
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

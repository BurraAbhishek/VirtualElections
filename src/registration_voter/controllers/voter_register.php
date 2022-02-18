<?php
	error_reporting(0);

	require_once '../../db/config/dbconfig.php';
	require_once '../../db/config/tablesconfig.php';
	require_once '../../db/controllers/post_validate.php';
	require_once '../../db/controllers/ssl.php';
	require_once '../../db/config/idconfig.php';
	require_once '../../db/config/shrugconfig.php';

    try {
        $dbconn = new Connection();
        $conn = $dbconn->openConnection();
    } catch (Exception $e) {
        header("Location: ../status/registration_failed.html");
    }

	$tables = new Table();
	$voter_table = $tables->getVoterList();
	$voter = $voter_table["table"];
	$voter_id = $voter_table["id"];
	$voter_name = $voter_table["voter_name"];
	$dob = $voter_table["voter_dob"];
	$idno = $voter_table["idproof_value"];
	$idproof = $voter_table["idproof_type"];
	$gender = $voter_table["voter_gender"];
	$password = $voter_table["password"];

	$crypto = new SecureData();
	$id_validator = new IDProof();

	try {
		if(isset($_POST['save'])) {
			if(($_POST['cpd1']) != ($_POST['cpd2'])) {
				header("Location: ../status/passwordnotconfirmed.html");
			} else {
				$cid = validateDatatype(generate_id(12), 'string');
				$cname = $crypto->encrypt(validateName(
					validateDatatype($_POST['cname'], 'string'))
				);
				$cdob = $crypto->encrypt(
					validateDatatype($_POST['cdob'], 'ANY')
				);
				$citype_unsafe = validateDatatype($_POST['citype'], 'string');
				if (!$id_validator->validate_idproof($citype_unsafe)) {
					throw new Exception("Invalid Identity proof");
				}
				$citype = $crypto->encrypt(validateName(
					$citype_unsafe)
				);
				$cidno = $crypto->encrypt(validateName(
					validateDatatype($_POST['cidno'], 'string'))
				);
				$cgender = $crypto->encrypt(validateName(
					validateDatatype($_POST['cgender'], 'string'))
				);
				$cpd = validateDatatype($_POST['cpd1'], 'ANY');
				$cpd1 = password_hash($cpd, PASSWORD_DEFAULT);
				$sql = $conn->prepare(
					"INSERT INTO 
					$voter ($voter_id, $voter_name, $dob, $idno, $idproof, $gender, $password) 
					values (:cid,:cname,:cdob,:cidno,:citype,:cgender,:cpd)"
				);
				$sql->bindParam(':cid', $cid, PDO::PARAM_STR, 12);
				$sql->bindParam(':cname', $cname, PDO::PARAM_STR, 256);
				$sql->bindParam(':cdob', $cdob);
				$sql->bindParam(':citype', $citype, PDO::PARAM_STR, 256);
				$sql->bindParam(':cidno', $cidno, PDO::PARAM_STR, 256);
				$sql->bindParam(':cgender', $cgender, PDO::PARAM_STR, 128);
				$sql->bindParam(':cpd', $cpd1);
				if($sql->execute()) {
					header("Location: ../status/registration_success.html");
				} else {
					header("Location: ../status/registration_failed.html");
				}
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

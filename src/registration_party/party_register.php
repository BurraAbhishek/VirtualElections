<?php

	require '../db/dbconfig.php';
	require '../db/tablesconfig.php';

	$tables = new Table();
	$party = $tables->getPartyList();
	$dbconn = new Connection();
	$conn = $dbconn->openConnection();

	try {
		if(isset($_POST['save'])){
			$pname = $_POST['pname'];
			$cname = $_POST['cname'];
			$citype = $_POST['citype'];
			$cidno = $_POST['cidno'];
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

	catch(PDOException $e)
	{
		echo $e->getMessage();
	}

	$conn = null;
?>

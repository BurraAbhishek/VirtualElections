<?php
	error_reporting(0);

	require_once '../controllers/voter_class.php';
	require_once '../controllers/ssl.php';

	$s = new SecureData();
	$v = new VoterData();


	try {
		if(isset($_POST['submit'])) {
			$pwd = $_POST['cpd1'];
			$citype = $s->encrypt($_POST['citype']);
			$cidno = $s->encrypt($_POST['cidno']);
			$v->authenticateVoter($citype, $cidno, $pwd);
		}
	}

	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>

<?php
	error_reporting(0);
	session_start();

	if(empty($_SESSION['token'])) {
		header('location: ../../public/oops/403.html');
	}

	if(!empty($_POST['token'])) {
		if(!hash_equals($_SESSION['token'], $_POST['token'])) {
			header('location: ../../public/oops/corrections_userinput.html');
		} else {
			$_SESSION['alt'] = $_POST['token'];
		}
	} else {
		header('location: ../../public/oops/403.html');
	}

	require_once 'voter_class.php';
	require_once '../../db/controllers/ssl.php';

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

	catch(Exception $e) {
		header('location: ../../public/oops/403.html');
	}
?>

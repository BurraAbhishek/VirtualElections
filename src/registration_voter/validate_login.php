<?php
	//error_reporting(0);

	require '../controllers/voter_class.php';

	$v = new VoterData();
	try {
		if(isset($_POST['submit'])) {
			$pwd = $_POST['cpd1'];
			$citype = $_POST['citype'];
			$cidno = $_POST['cidno'];
			$v->authenticateVoter($citype, $cidno, $pwd);
		}
	}

	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>

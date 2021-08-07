<?php
	error_reporting(0);
	session_start();
?>

<?php
	
	require_once '../../db/config/dbconfig.php';
	require_once '../../db/config/tablesconfig.php';
	require_once '../../db/controllers/ssl.php';

    $tables = new Table();
    $votescast = $tables->getVotes();
	$votes = $votescast["table"];
	$voter_id = $votescast["voter"];
	$party_id = $votescast["party"];
    $partytable = $tables->getPartyList();
	$party = $partytable["table"];
	$partyid = $partytable["id"];
	$party_name = $partytable["party_name"];
	$send = new SecureData();
    $dbconn = new Connection();
    $conn = $dbconn->openConnection();

	try {	
		if(!empty($_POST['token'])) {
			if(hash_equals($_SESSION['token'], $_POST['token'])) {
				$voterid = $_SESSION["voterid"];
				$voted_for = $send->encrypt($_POST["myinput"]);
				$sql = $conn->prepare("SELECT $partyid FROM $party WHERE $party_name = :voted_for");
				$sql->execute([':voted_for' => $voted_for]);
				$result = $sql->fetchAll();
				$v = 0;
				foreach($result as $s){
					$v = $s["party_id"];
				}
				$stmt = $conn->prepare("INSERT INTO $votes ($voter_id, $party_id) values (:voter_id, :v)");
				$stmt->bindParam(':voter_id', $voterid, PDO::PARAM_INT);
				$stmt->bindParam(':v', $v, PDO::PARAM_INT);
				if($stmt->execute()){
					session_destroy();
					setcookie("PHPSESSID", "", time() - 86400);
					header("location: ../status/votecomplete.html");
				} else {
					header("location: ../status/voteunrecognized.php");
				}
			} else {
				header("location: ../../public/oops/corrections_userinput.html");
			}
		} else {
			header("location: ../../public/oops/403.html");
		}
	}

	catch(PDOException $e) {
		header("location: ../../public/oops/503.html");
	}
?>

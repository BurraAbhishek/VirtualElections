<?php
	error_reporting(0);
	session_start();
?>

<?php
	
	require_once '../db/dbconfig.php';
	require_once '../db/tablesconfig.php';
	require_once '../controllers/ssl.php';

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
			echo '<script>if(sessionStorage.votername){sessionStorage.removeItem("votername");}</script>';
			echo '<script>if(sessionStorage.voted){sessionStorage.removeItem("voted");}</script>';
			echo '<script>if(sessionStorage.parties){sessionStorage.removeItem("parties");}</script>';
			echo '<script>window.location.replace("votecomplete.html");</script>';
		} else {
			echo '<script>alert("VoteError: This vote was not recognized.");</script>';
			echo '<script>window.location.replace("election.php");</script>';
		}
	}

	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>

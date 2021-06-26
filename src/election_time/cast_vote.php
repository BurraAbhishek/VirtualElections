<?php
	error_reporting(0);
	session_start();
?>

<?php
	
	require '../db/dbconfig.php';
	require '../db/tablesconfig.php';

    $tables = new Table();
    $votescast = $tables->getVotes();
    $party = $tables->getPartyList();
    $dbconn = new Connection();
    $conn = $dbconn->openConnection();

	try {	
		$voter_id = $_SESSION["voterid"];
		$voted_for = (string)$_POST["myinput"];
		$sql = $conn->prepare("SELECT party_id FROM $party WHERE party_name = :voted_for");
		$sql->execute(['voted_for' => $voted_for]);
		$result = $sql->fetchAll();
		$v = 0;
		foreach($result as $s){
			$v = $s["party_id"];
		}
		$stmt = $conn->prepare("INSERT INTO $votescast (voter_id, party_id) values (:voter_id, :v)");
		$stmt->bindParam(':voter_id', $voter_id, PDO::PARAM_INT);
		$stmt->bindParam(':v', $v, PDO::PARAM_INT);
		if($stmt->execute()){
			session_destroy();
			echo '<script>if(sessionStorage.votername){sessionStorage.removeItem("votername");}</script>';
			echo '<script>if(sessionStorage.voted){sessionStorage.removeItem("voted");}</script>';
			echo '<script>if(sessionStorage.parties){sessionStorage.removeItem("parties");}</script>';
			echo '<script>window.location.replace("votecomplete.html");</script>';
		} else {
			echo '<script>alert("VoteError: This vote was not recognized.");</script>';
			echo '<script>window.location.replace("election.html");</script>';
		}
	}

	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>

<?php
	error_reporting(0);
	session_start();
?>

<?php
	
	require_once '../db/dbconfig.php';
	require_once '../db/tablesconfig.php';
	require_once '../controllers/ssl.php';

    $tables = new Table();
    $votes_table = $tables->getVotes();
	$votescast = $votes_table["table"];
	$voterid = $votes_table["voter"];
    $party_table = $tables->getPartyList();
	$party = $party_table["table"];
	$partyname = $party_table["party_name"];
	$candidate = $party_table["candidate_name"];
	$show = new SecureData();
    $dbconn = new Connection();
    $conn = $dbconn->openConnection();

	try {
		$voter_id = $_SESSION["voterid"];
		$sql = $conn->prepare("SELECT * FROM $votescast WHERE $voterid = :voter_id");
		$sql->execute(['voter_id' => $voter_id]);
		$result = $sql->fetchAll();
		if(count($result)==0){
			$stmt = $conn->prepare("SELECT * FROM $party");
			$stmt->execute();
			$r = $stmt->fetchAll();
			$a = [];
			foreach($r as $s){
				$b = [];
				array_push($b,$show->decrypt($s[$partyname]),$show->decrypt($s[$candidate]));
				array_push($a,$b);
			}
			$c = json_encode($a);
			$v = $_SESSION["votername"];
			echo '<script>sessionStorage.setItem("parties",JSON.stringify(';
			echo "$c";
			echo '));</script>';
			echo '<script>sessionStorage.setItem("votername","';
			echo "$v";
			echo '");</script>';
			echo '<script>window.location.replace("election.php");</script>';
		} else {
			session_destroy();
			echo '<script>window.location.replace("votecomplete.html");</script>';
		}
	}

	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>

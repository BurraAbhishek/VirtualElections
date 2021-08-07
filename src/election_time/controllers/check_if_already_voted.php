<?php
	error_reporting(0);
	session_start();
	if(!empty($_SESSION['alt'])) {
		if(!hash_equals($_SESSION['token'], $_SESSION['alt'])) {
			header('location: ../../public/oops/corrections_userinput.html');
		}
	} else {
		header('location: ../../public/oops/403.html');
	}
?>

<?php
	
	require_once '../../db/config/dbconfig.php';
	require_once '../../db/config/tablesconfig.php';
	require_once '../../db/controllers/ssl.php';

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
			echo '<script>window.location.replace("../main/election.php");</script>';
		} else {
			session_destroy();
			header('location: ../status/votecomplete.html');
		}
	}

	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>

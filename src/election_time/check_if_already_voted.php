<?php
	error_reporting(0);
	session_start();
?>

<?php
	$servername = "localhost";
	$username = "root";
	$password = "";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=virtualelection", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_SILENT);	
		$voter_id = $_SESSION["voterid"];
		$sql = $conn->prepare('SELECT * FROM election WHERE voter_id = :voter_id');
		$sql->execute(['voter_id' => $voter_id]);
		$result = $sql->fetchAll();
		if(count($result)==0){
			$stmt = $conn->prepare("SELECT * FROM parties");
			$stmt->execute();
			$r = $stmt->fetchAll();
			$a = [];
			foreach($r as $s){
				$b = [];
				array_push($b,$s['party_name'],$s['candidate']);
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

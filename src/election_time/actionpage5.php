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
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);	
$voter_id = $_SESSION["voterid"];
$voted_for = $_POST["myinput"];
$sql = $conn->prepare('SELECT party_id FROM parties WHERE party_name = :voted_for');
$sql->execute(['voted_for' => $voted_for]);
$result = $sql->fetchAll();
$v = 0;
foreach($result as $s){
$v = $s["party_id"];
}
$stmt = $conn->prepare("INSERT INTO election (voter_id, party_id) values (:voter_id, :v)");
$stmt->bindParam(':voter_id',$voter_id);
$stmt->bindParam(':v',$v);
if($stmt->execute()){
session_destroy();
echo '<script>window.location.replace("votecomplete.html");</script>';
}else{
echo '<script>window.location.replace("election.html");</script>';
}}

catch(PDOException $e)
{
	echo $e->getMessage();
}
?>
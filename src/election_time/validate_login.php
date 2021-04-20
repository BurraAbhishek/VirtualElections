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
if(isset($_POST['save'])) {
$pwd = $_POST['cpd1'];
$citype = $_POST['citype'];
$cidno = $_POST['cidno'];
$sth = $conn->prepare("SELECT * FROM voter WHERE idproof = :citype AND idno = :cidno");
$sth->execute(['citype' => $citype, 'cidno' => $cidno]);
$userid = $sth->fetchAll();
foreach($userid as $u){
$u1 = $u['idproof'];
$u2 = $u['idno'];
$u3 = $u['password'];
}
if(($citype == $u1)&&($cidno == $u2)&&(password_verify($pwd,$u3))) {
$_SESSION["voterid"] = $u['voter_id'];
$_SESSION["votername"] = $u['voter_name'];
echo '<script>window.location.href="check_if_already_voted.php";</script>';
}else{
echo '<script>alert("ERROR: Voter does not exist.");window.location.href="voter_login.html";</script>';
}
}}

catch(PDOException $e)
{
	echo $e->getMessage();
}
?>
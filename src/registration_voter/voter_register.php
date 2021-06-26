<?php
error_reporting(0);

require '../db/dbconfig.php';
require '../db/tablesconfig.php';

$tables = new Table();
$voter = $tables->getVoterList();
$dbconn = new Connection();
$conn = $dbconn->openConnection();
try {
if(isset($_POST['save'])) {
if(($_POST['cpd1'])!=($_POST['cpd2'])) {
echo '<script>alert("Confirm your password properly");window.location.href="registration.php";</script>';
} else {
$cname = $_POST['cname'];
$cdob = $_POST['cdob'];
$citype = $_POST['citype'];
$cidno = $_POST['cidno'];
$cgender = $_POST['cgender'];
$cpd = $_POST['cpd1'];
$cpd1 = password_hash($cpd, PASSWORD_DEFAULT);
$sql = $conn->prepare("INSERT INTO $voter (voter_name, dob, idno, idproof, gender, password) values
(:cname,:cdob,:cidno,:citype,:cgender,:cpd)");
$sql->bindParam(':cname', $cname, PDO::PARAM_STR, 100);
$sql->bindParam(':cdob', $cdob);
$sql->bindParam(':citype', $citype, PDO::PARAM_STR, 20);
$sql->bindParam(':cidno', $cidno, PDO::PARAM_STR, 50);
$sql->bindParam(':cgender', $cgender, PDO::PARAM_STR, 6);
$sql->bindParam(':cpd', $cpd1);
if($sql->execute()) {echo '<script>window.location.href="registration_success.html";</script>';} 
else {echo '<script>alert("CredentialsError: Registration Failed! Please try again.");window.location.href="registration.php";</script>';}
}}
}

catch(PDOException $e)
{
	echo $e->getMessage();
}

$conn = null;
?>

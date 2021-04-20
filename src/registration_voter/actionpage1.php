<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
$conn = new PDO("mysql:host=$servername;dbname=virtualelection", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
if(isset($_POST['save'])) {
if(($_POST['cpd1'])!=($_POST['cpd2'])) {
echo '<script>alert("Confirm your password properly");window.location.href="srg.html";</script>';
} else {
$cname = $_POST['cname'];
$cdob = $_POST['cdob'];
$citype = $_POST['citype'];
$cidno = $_POST['cidno'];
$cgender = $_POST['cgender'];
$cpd = $_POST['cpd1'];
$cpd1 = password_hash($cpd, PASSWORD_DEFAULT);
$sql = $conn->prepare("INSERT INTO voter (voter_name, dob, idno, idproof, gender, password) values
(:cname,:cdob,:cidno,:citype,:cgender,:cpd)");
$sql->bindParam(':cname', $cname, PDO::PARAM_STR, 100);
$sql->bindParam(':cdob', $cdob);
$sql->bindParam(':citype', $citype, PDO::PARAM_STR, 20);
$sql->bindParam(':cidno', $cidno, PDO::PARAM_STR, 100);
$sql->bindParam(':cgender', $cgender, PDO::PARAM_STR, 6);
$sql->bindParam(':cpd', $cpd1);
if($sql->execute()) {echo '<script>window.location.href="srgss.html";</script>';} 
else {echo '<script>alert("Enter the details properly");window.location.href="srg.html";</script>';}
}}
}

catch(PDOException $e)
{
	echo $e->getMessage();
}

$conn = null;
?>
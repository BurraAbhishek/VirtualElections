<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
$conn = new PDO("mysql:host=$servername;dbname=virtualelection", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
if(isset($_POST['save'])){
$pname = $_POST['pname'];
$cname = $_POST['cname'];
$sql = $conn->prepare("INSERT INTO parties (party_name, candidate) values
(:pname,:cname)");
$sql->bindParam(':pname',$pname);
$sql->bindParam(':cname',$cname);
if($sql->execute()) {echo '<script>window.location.href="registration_success.html";</script>';} 
else {echo '<script>alert("Enter the details properly");window.location.href="registration.html";</script>';}
}}

catch(PDOException $e)
{
	echo $e->getMessage();
}

$conn = null;
?>
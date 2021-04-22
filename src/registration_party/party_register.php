<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/virtualelection.css">
    <title>Party Registration</title>
</head>

<body>
    <header class="appbar">Candidate Registration</header>
    <div id="mainbody" class="mainbody">
        <form action="#" method="post">
            <p1>
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: right;">Party Name: </td>
                        <td><input type="text" name="pname" id="pname" required></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">Candidate Name: </td>
                        <td><input type="text" name="cname" id="cname" required></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><abbr title="Type of ID Proof, default is passport"
                                style="text-decoration: none;">Identification type: </abbr></td>
                        <td><input type="text" name="citype" id="citype" value="Passport" required></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">Passport / ID Number of Candidate: </td>
                        <td><input type="text" name="cidno" id="cidno" required></td>
                    </tr>                    
                    <tr>
                        <td colspan=2 style="text-align: center;"><input class="submitbtn" type="submit" value="SUBMIT"
                                name="save"></td>
                    </tr>
                </table>
            </p1>
        </form>
    </div>

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
$citype = $_POST['citype'];
$cidno = $_POST['cidno'];
$sql = $conn->prepare("INSERT INTO parties (party_name, candidate, idno, idproof) values
(:pname,:cname,:cidno, :citype)");
$sql->bindParam(':pname',$pname, PDO::PARAM_STR, 100);
$sql->bindParam(':cname',$cname, PDO::PARAM_STR, 100);
$sql->bindParam(':citype', $citype, PDO::PARAM_STR, 20);
$sql->bindParam(':cidno', $cidno, PDO::PARAM_STR, 50);
if($sql->execute()) {echo '<script>window.location.href="registration_success.html";</script>';} 
else {echo '<script>alert("Enter the details properly");window.location.reload();</script>';}
}}

catch(PDOException $e)
{
	echo $e->getMessage();
}

$conn = null;
?>

</body>

</html>
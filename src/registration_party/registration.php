<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/virtualelection.css">
    <title>Party Registration</title>
</head>

<body>
    <header class="appbar">Contestant Registration</header>

    <?php
error_reporting(0);

$servername = "localhost";
$username = "root";
$password = "";

try {
$conn = new PDO("mysql:host=$servername;dbname=virtualelection", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_SILENT);
$sql1 = $conn->prepare("SELECT partyregistrations FROM admin WHERE admin_id = 'admin'");
$sql1->execute();
$status = $sql1->fetchAll();
$html = '<div id="mainbody" class="mainbody">
        <form action="party_register.php" method="post">
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
    </div>';

if($status[0]['partyregistrations'] != 0) {
$html = preg_replace('#<div id="mainbody">(.*?)</div>#', '', $html);
echo '<h2>This section is closed</h2>';
} else {
echo $html;
}

}

catch(PDOException $e)
{
	echo $e->getMessage();
}
?>

</body>

</html>

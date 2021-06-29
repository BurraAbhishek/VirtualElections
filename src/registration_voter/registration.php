<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/virtualelection.css">
    <title>Voter Registration</title>
    <script src="agecheck.js"></script>
</head>

<body>
    <header class="appbar">Voter Registration</header>

    <?php
        error_reporting(0);
            
        require '../db/dbconfig.php';
        require "../db/tablesconfig.php";

            
        try {
            $tables = new Table();
            $admin = $tables->getAdminStatus();
            $dbconn = new Connection();
            $conn = $dbconn->openConnection();
            $sql1 = $conn->prepare("SELECT voterregistrations FROM $admin WHERE admin_id = 'admin'");
            $sql1->execute();
            $status = $sql1->fetchAll();
            $html = '<div id="mainbody" class="mainbody">
                    <form action="voter_register.php" name="rForm" method="post" onsubmit="javascript:return validateForm();">
                        <p1>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="text-align: right;">Voter\'s Name: </td>
                                    <td><input type="text" name="cname" id="cname" pattern="[^/<>;:@#&%=[\]{\}\\\*\$!\?\/\|]+" title="Maximum 100 characters. The following characters are prohibited: !|@#$%^&*[]{}<>;?~:\/=" required></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;">Date of birth: </td>
                                    <td><input type="date" name="cdob" id="cdob" required></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;">Gender: </td>
                                    <td><select name="cgender" id="cgender">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><abbr title="Type of ID Proof, default is passport"
                                            style="text-decoration: none;">Identification type: </abbr></td>
                                    <td><input type="text" name="citype" id="citype" value="Passport" pattern="[^/<>;:@#&%=[\]{\}\\\*\$!\?\/\|]+" title="Maximum 20 characters. The following characters are prohibited: !|@#$%^&*[]{}<>;?~:\/=" required></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;">Passport / ID Number: </td>
                                    <td><input type="text" name="cidno" id="cidno" pattern="^(?!^0+$)[a-zA-Z0-9]{3,50}$" title="Only 3 to 50 characters. Only numbers, uppercase and lowercase. The sequence should not be all 0s." required></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;">Enter Password: </td>
                                    <td><input type="password" name="cpd1" id="cpd1" required></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;">Confirm Password: </td>
                                    <td><input type="password" name="cpd2" id="cpd2"></td>
                                </tr>
                                <tr>
                                    <td colspan=2 style="text-align: center;"><input class="submitbtn" type="submit" value="SUBMIT"
                                            name="save"></td>
                                </tr>
                            </table>
                        </p1>
                    </form>
                </div>';

            if($status[0]['voterregistrations'] != 0) {
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

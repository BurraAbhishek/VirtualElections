<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../public/controllers/css.js"></script>
    <script>
        loadCSS(1);
    </script>
    <title>Voter Registration</title>
    <script src="prevalidate/agecheck.js"></script>
</head>

<body>
    <header class="appbar">Voter Registration</header>

    <?php
        error_reporting(0);
            
        require '../db/config/dbconfig.php';
        require "../db/config/tablesconfig.php";
    
        try {
            $dbconn = new Connection();
            $conn = $dbconn->openConnection();
        } catch (Exception $e) {
            header('location: ../public/oops/503.html');
        }
        $tables = new Table();
        $admin = $tables->getAdminStatus();
        $admin_table = $admin["table"];
        $voter = $admin["voter"];
        $admin_id = $admin["id"];
        $id_default = $admin["id_default"];

        try {
            $sql = $conn->prepare("SELECT $voter FROM $admin_table WHERE $admin_id = :a");
            $sql->bindParam(':a', $id_default);
            $sql->execute();
            $status = $sql->fetchAll();
            $html = '<div id="mainbody" class="mainbody">
                    <form action="controllers/voter_register.php" name="rForm" method="post" onsubmit="javascript:return validateForm();">
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

            if($status[0][$voter] != 0) {
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

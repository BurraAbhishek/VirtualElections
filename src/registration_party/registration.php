<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../controllers/css.js"></script>
    <script>
        loadCSS(1);
    </script>
    <title>Party Registration</title>
</head>

<body>
    <header class="appbar">Contestant Registration</header>

    <?php
        error_reporting(0);

        require '../db/dbconfig.php';
        require '../db/tablesconfig.php';

        $tables = new Table();
        $admin = $tables->getAdminStatus();
        $admin_table = $admin["table"];
        $party = $admin["party"];
        $admin_id = $admin["id"];
        $id_default = $admin["id_default"];
        $dbconn = new Connection();
        $conn = $dbconn->openConnection();

        try {         
            $sql = $conn->prepare("SELECT $party FROM $admin_table WHERE $admin_id = :a");
            $sql->bindParam(':a', $id_default);
            $sql->execute();
            $status = $sql->fetchAll();
            $html = '<div id="mainbody" class="mainbody">
                    <form action="party_register.php" method="post">
                        <p1>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="text-align: right;">Party Name: </td>
                                    <td><input type="text" name="pname" id="pname" pattern="[^/<>;:@#&%=[\]{\}\\\*\$!\?\/\|]+" title="Maximum 100 characters. The following characters are prohibited: !|@#$%^&*[]{}<>;?~:\/=" required></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;">Candidate Name: </td>
                                    <td><input type="text" name="cname" id="cname" pattern="[^/<>;:@#&%=[\]{\}\\\*\$!\?\/\|]+" title="Maximum 100 characters. The following characters are prohibited: !|@#$%^&*[]{}<>;?~:\/=" required></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><abbr title="Type of ID Proof, default is passport"
                                            style="text-decoration: none;">Identification type: </abbr></td>
                                    <td><input type="text" name="citype" id="citype" value="Passport" pattern="[^/<>;:@#&%=[\]{\}\\\*\$!\?\/\|]+" title="Maximum 20 characters. The following characters are prohibited: !|@#$%^&*[]{}<>;?~:\/=" required></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;">Passport / ID Number of Candidate: </td>
                                    <td><input type="text" name="cidno" id="cidno" pattern="^(?!^0+$)[a-zA-Z0-9]{3,50}$" title="Only 3 to 50 characters. Only numbers, uppercase and lowercase. The sequence should not be all 0s." required></td>
                                </tr>                    
                                <tr>
                                    <td colspan=2 style="text-align: center;"><input class="submitbtn" type="submit" value="SUBMIT"
                                            name="save"></td>
                                </tr>
                            </table>
                        </p1>
                    </form>
                </div>';

            if($status[0][$party] != 0) {
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

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../public/controllers/css.js"></script>
    <script>
        loadCSS(1);
    </script>
    <title>Virtual Elections</title>
</head>

<body>
    <header class="appbar">Register for voting</header>

    <?php
        error_reporting(0);
            
        require '../db/config/dbconfig.php';
        require '../db/config/tablesconfig.php';
        require_once '../db/config/idconfig.php';

        try {
            $dbconn = new Connection();
            $conn = $dbconn->openConnection();
        } catch (Exception $e) {
            header('location: ../public/oops/503.html');
        }

        session_set_cookie_params([
            'SameSite' => "Strict",
            'HttpOnly' => true,
        ]);
        session_start();
        $_SESSION['token'] = bin2hex(random_bytes(32));
        $token = $_SESSION['token'];

        $tables = new Table();
        $admin = $tables->getAdminStatus();
        $admin_table = $admin["table"];
        $votecasting = $admin["votecast"];
        $admin_id = $admin["id"];
        $id_default = $admin["id_default"];
        $id_proofs = new IDProof();
        $ids_list = $id_proofs->get_options();

        try {
            $sql1 = $conn->prepare(
                "SELECT $votecasting FROM $admin_table WHERE $admin_id = :a"
            );
            $sql1->bindParam(':a', $id_default);
            $sql1->execute();
            $status = $sql1->fetchAll();
            $html = '<div id="mainbody" class="mainbody">
            <form
                action="controllers/validate_login.php"
                method="post"
            >
                <p1>
                    <table style="width: 100%">
                        <tr>
                            <td style="text-align: right">
                                Identification proof:
                            </td>
                            <td>
                                <select name="citype" id="citype">'.$ids_list.'</select>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right">
                                Passport / ID Number:
                            </td>
                            <td>
                                <input
                                    type="text"
                                    name="cidno"
                                    id="cidno"
                                    required
                                />
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right">
                                Enter Password:
                            </td>
                            <td>
                                <input
                                    type="password"
                                    name="cpd1"
                                    id="cpd1"
                                    required
                                />
                            </td>
                        </tr>
                        <tr style="display: none">
                            <td>&nbsp;</td>
                            <td>
                                <input
                                    type="password"
                                    name="token"
                                    id="token"
                                    value="';
                            $html .= $token;
                            $html .= '"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td
                                colspan="2"
                                style="text-align: center"
                            >
                                <input
                                    class="submitbtn"
                                    type="submit"
                                    value="SUBMIT"
                                    name="save"
                                />
                            </td>
                        </tr>
                    </table>
                </p1>
            </form>
        </div>';        
            if($status[0][$votecasting] != 0) {
                $html = preg_replace(
                    '#<div id="mainbody">(.*?)</div>#', 
                    '', 
                    $html);
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

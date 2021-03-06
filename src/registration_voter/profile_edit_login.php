<?php
    error_reporting(0);

    require_once '../db/config/dbconfig.php';
    require_once '../db/config/idconfig.php';

    try {
        $conn = new Connection();
        $open_conn = $conn->openConnection();
    } catch (Exception $e) {
        header('location: ../public/oops/503.html');
    }

    session_set_cookie_params([
        'expires' => 0,
        'SameSite' => "Strict",
        'HttpOnly' => true,
    ]);
    session_start();
    $_SESSION['token'] = bin2hex(random_bytes(32));
    $token = $_SESSION['token'];
    $id_proofs = new IDProof();
    $ids_list = $id_proofs->get_options();
?>

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
    <header class="appbar">Edit Voter Profile</header>

    <div id="mainbody" class="mainbody">
        <form action="controllers/validate_login.php" method="post">
            <p1>
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: right;">
                        <abbr title="Type of ID Proof, default is passport"
                                style="text-decoration: none;">
                                Identification type: </abbr></td>
                        <td>
                            <select name="citype" id="citype">
                            <?php
                                echo $ids_list
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                        Passport / ID Number: </td>
                        <td><input type="text" name="cidno" id="cidno" 
                        required></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">Enter Password: </td>
                        <td><input type="password" name="cpd1" id="cpd1" 
                        required></td>
                    </tr>
                    <?php
                        echo '<tr style="display: none"><td>&nbsp;</td>'; 
                        echo '<td><input type="password" name="token" id="token" value="';
                        echo $token;
                        echo '"></td>
                    </tr>';
                    ?>
                    <tr>
                        <td colspan=2 style="text-align: center;">
                        <input class="submitbtn" type="submit" value="SUBMIT"
                                name="submit"></td>
                    </tr>
                </table>
            </p1>
        </form>
    </div>
</body>

</html>

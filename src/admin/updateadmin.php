<?php
    require_once "../db/dbconfig.php";
    require_once "../db/tablesconfig.php";

    $dbconn = new Connection();
    $conn = $dbconn->openConnection();
    $table = new Table();
    $admin = $table->getAdminStatus();
    $admin_table = $admin["table"];
    $admin_id = $admin["id"];
    $id_default = $admin["id_default"];
    $password_attr = $admin["password"];
    $password_default = password_hash($admin["password_default"], PASSWORD_DEFAULT);
    $sql = $conn->prepare("UPDATE $admin_table SET $admin_id = :adminid, $password_attr = :hashpw");
    $sql->bindParam(':adminid', $id_default);
    $sql->bindParam(':hashpw', $password_default);
    $sql->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Admin Details</title>
    <script src="../controllers/css.js"></script>
    <script>
        loadCSS(1);
    </script>
    <style>
        p1 {
            font-size: 1.25em;
            padding: 0;
        }

        .flex-links {
            background-color: inherit;
            color: #3399FF;
            text-decoration: none;
            font-size: inherit;
            display: inline;
            margin: 0;
            padding: 0;
        }

        .text-padded {
            padding: 0% 0.5%;
        }

        li {
            padding: 0.5% 0;
        }

        .fullwidth {
            width: 100%;
        }

        .rightalign {
            text-align: right;
        }

        select {
            font-size: 1em;
        }
    </style>
</head>

<body>
    <h1>
        Updated database. You can close this page now.
    </h1>
</body>

</html>
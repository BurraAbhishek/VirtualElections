<?php
    error_reporting(0);

    require_once "../db/config/tablesconfig.php";
    require_once "../db/config/dbconfig.php";
    require_once "../db/controllers/ssl.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../public/controllers/css.js"></script>
    <script>
        loadCSS(1);
    </script>
    <title>Vote Count</title>
    <style>
        .result_table {
            width: 100%;
            table-layout: fixed;
        }
        a {
            color: #FFFF00;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <header>
        <div class="appbar">Vote Count</div>
        <h1>Click <a href="genderturnout.php">here</a> to check the voter turnout</h1>
    </header>
    <?php

        $results = [];

        try {
            $dbconn = new Connection();
            $conn = $dbconn->openConnection();
        } catch (Exception $e) {
            header('location: ../public/oops/503.html');
        }

        $tables = new Table();
        $result = $tables->getResults();
        $rtable = $result["table"];
        $rcontestant = $result["party"];
        $rdesc = $result["count"];
        $crypto = new SecureData();
        $party = $tables->getPartyList();
        $ptable = $party["table"];
        $partyid = $party["id"];
        $partyname = $party["party_name"];

        $sql = $conn->prepare("SELECT * FROM `$rtable` ORDER BY `$rdesc` DESC");
        $sql->execute();
        $results = $sql->fetchAll();
    ?>
    <div id="mainbody" class="mainbody"><br>
        <table class="result_table" id="table1">
            <tr>
                <th> Candidate </th>
                <th> Votes won </th>
            </tr>
            <?php

            foreach($results as $r) {
                $rsql = $conn->prepare(
                    "SELECT `$partyname` FROM `$ptable` WHERE `$partyid`=:p"
                );
                $rsql->bindParam(':p', $crypto->decrypt($r[$rcontestant]));
                $rsql->execute();
                $sparty = $rsql->fetchAll();
                $rcandidate = $crypto->decrypt($sparty[0][$partyname]);
                $rcount = $r[$rdesc];
                echo "<tr><td>$rcandidate</td><td>$rcount</td></tr>";
            }

            ?>
        </table>
    </div>
</body>

</html>

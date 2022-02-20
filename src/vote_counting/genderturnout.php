<?php
    error_reporting(0);

    require_once "../db/config/tablesconfig.php";
    require_once "../db/config/dbconfig.php";
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
    <?php

        function pretty_percent_divide($dividend, $divisor) {
            $q = 0;
            if ($divisor != 0) {
                $q = $dividend / $divisor;
            }
            return round((100 * $q), 2);
        }

        $results = [];

        try {
            $dbconn = new Connection();
            $conn = $dbconn->openConnection();
        } catch (Exception $e) {
            header('location: ../public/oops/503.html');
        }

        $tables = new Table();
        $turnout = $tables->getGenderTurnout();
        $ttable = $turnout["table"];
        $tid = $turnout["id"];
        $m = $turnout["male"];
        $f = $turnout["female"];
        $o = $turnout["other"];
        $g = $turnout["total"];

        $sql = $conn->prepare("SELECT * FROM $ttable");
        $sql->execute();
        $result = $sql->fetchAll();
        foreach ($result as $rs) {
            if ($rs[$tid] == "gender_all") {
                $gender_all = $rs;
            } else if ($rs[$tid] == "gender_composition") {
                $gender_composition = $rs;
            }
        }
        $stats_percent = array(
            $m => pretty_percent_divide(
                $gender_composition[$m],
                $gender_composition[$g]
            ),
            $f => pretty_percent_divide(
                $gender_composition[$f],
                $gender_composition[$g]
            ),
            $o => pretty_percent_divide(
                $gender_composition[$o],
                $gender_composition[$g]
            ),
            $g => pretty_percent_divide(
                $gender_composition[$g],
                $gender_composition[$g]
            )
        );
        $stats_turnout = array(
            $m => pretty_percent_divide(
                $gender_composition[$m],
                $gender_all[$m]
            ),
            $f => pretty_percent_divide(
                $gender_composition[$f],
                $gender_all[$f]
            ),
            $o => pretty_percent_divide(
                $gender_composition[$o],
                $gender_all[$o]
            ),
            $g => pretty_percent_divide(
                $gender_composition[$g],
                $gender_all[$g]
            )
        );

    ?>
    <header>
        <div class="appbar">Vote Count</div>
        <h1>Click <a href="results.php">here</a> to check the results</h1>
    </header>
        <table class="result_table">
            <tr>
                <th>Gender</th>
                <th>Total</th>
                <th>Participated</th>
                <th>Composition (%)</th>
                <th>Turnout (%)</th>
            </tr>
            <tr>
                <td>Male</td>
                <td><?php echo $gender_all[$m]; ?></td>
                <td><?php echo $gender_composition[$m]; ?></td>
                <td><?php echo $stats_percent[$m]; ?></td>
                <td><?php echo $stats_turnout[$m]; ?></td>
            </tr>
            <tr>
                <td>Female</td>
                <td><?php echo $gender_all[$f]; ?></td>
                <td><?php echo $gender_composition[$f]; ?></td>
                <td><?php echo $stats_percent[$f]; ?></td>
                <td><?php echo $stats_turnout[$f]; ?></td>
            </tr>
            <tr>
                <td>Other</td>
                <td><?php echo $gender_all[$o]; ?></td>
                <td><?php echo $gender_composition[$o]; ?></td>
                <td><?php echo $stats_percent[$o]; ?></td>
                <td><?php echo $stats_turnout[$o]; ?></td>
            </tr>
            <tr>
                <td>Total</td>
                <td><?php echo $gender_all[$g]; ?></td>
                <td><?php echo $gender_composition[$g]; ?></td>
                <td><?php echo $stats_percent[$g]; ?></td>
                <td><?php echo $stats_turnout[$g]; ?></td>
            </tr>
        </table>
    </div>
</body>

</html>
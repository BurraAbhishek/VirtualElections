<?php
    require_once "../../db/config/dbconfig.php";
    require_once "../controllers/controlelection.php";

    try {
        $dbconn = new Connection();
        $conn = $dbconn->openConnection();
    } catch (Exception $e) {
        header('location: ../../public/oops/503.html');
    }

    $o = new OpenCloseModules();
    $o->accessAdminPortal();
    $a = $o->showCurrentStatus();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Access Control</title>
    <script src="../../public/controllers/css.js"></script>
    <script>
        loadCSS(2);
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
        Access Control
    </h1>
    <form action="controllerupdate.php" method="POST">
        <table class="fullwidth">
            <tr>
                <td class="rightalign">Voter Registration: </td>
                <td>
                    <select name="voter" id="voter" onchange="javascript:changeToggle('voter');">
                        <option id="voter0" value="0">Enabled</option>
                        <option id="voter1" value="1">Disabled</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="rightalign">Party Registration: </td>
                <td>
                    <select name="party" id="party" onchange="javascript:changeToggle('party');">
                        <option id="party0" value="0">Enabled</option>
                        <option id="party1" value="1">Disabled</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="rightalign">Voting: </td>
                <td>
                    <select name="votecast" id="votecast" onchange="javascript:changeToggle('votecast');">
                        <option id="votecast0" value="0">Enabled</option>
                        <option id="votecast1" value="1">Disabled</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="rightalign">Results: </td>
                <td>
                    <select name="results" id="results"  onchange="javascript:changeToggle('results');">
                        <option id="results0" value="0">Enabled</option>
                        <option id="results1" value="1">Disabled</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan=2 style="text-align: center;">
                    <span id="ifuptodate">Status: Changes saved to database</span>
                </td>
            </tr>
            <tr>
                <td colspan=2 style="text-align: center;">
                    <input class="submitbtn" type="submit" value="Save Changes" name="save">
                </td>
            </tr>
        </table>
    </form>

    <?php
        echo '<script> document.getElementById("voter';
        echo $a["0"];
        echo '").setAttribute("selected", "true"); </script>';
        echo '<script> document.getElementById("party';
        echo $a["1"];
        echo '").setAttribute("selected", "true"); </script>';
        echo '<script> document.getElementById("votecast';
        echo $a["2"];
        echo '").setAttribute("selected", "true"); </script>';
        echo '<script> document.getElementById("results';
        echo $a["3"];
        echo '").setAttribute("selected", "true"); </script>';
    ?>

    <script>
        function changeToggle(c) {
            for(var i = 0; i < 2; i++) {
                if(document.getElementById(c + i).hasAttribute("selected")) {
                    document.getElementById(c + i).removeAttribute("selected");
                }
            }
            document.getElementById("ifuptodate").innerHTML = "Status: Changes not saved to database";
        }
    </script>
</body>

</html>
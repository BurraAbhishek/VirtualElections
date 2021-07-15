<?php
    error_reporting(0);

    require_once "../db/tablesconfig.php";
    require_once "../db/dbconfig.php";
    require_once "../controllers/ssl.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../controllers/css.js"></script>
    <script>
        loadCSS(1);
    </script>
    <title>Vote Count</title>
</head>

<body>
    <!-- Please use the latest versions of Chrome (47+), Firefox (43+) or Edge (79+) to view this page -->
    <!-- If your browser is not listed, it means that this site has not yet been tested on that browser -->
    <header>
        <div class="appbar">Vote Count</div>
    </header>
    <div id="mainbody" class="mainbody"><br>
        <table id="table1" style="width:100%;table-layout:fixed;"></table>
    </div>
    <script>
        var s = [];
    </script>

    <?php
        $tables = new Table();
        $admin_data = $tables->getAdminStatus();
        $admin = $admin_data["table"];
        $admin_id = $admin_data["id"];
        $id_default = $admin_data["id_default"];
        $resultenabled = $admin_data["results"];
        $votesdata = $tables->getVotes();
        $votescast = $votesdata["table"];
        $votespartyid = $votesdata["party"];
        $party = $tables->getPartyList();
        $party_table = $party["table"];
        $party_name = $party["party_name"];
        $party_id = $party["id"];
        $s = new SecureData();
        $dbconn = new Connection();
        $conn = $dbconn->openConnection();

        try {
            $sql1 = $conn->prepare("SELECT $resultenabled FROM $admin WHERE $admin_id = :a");
            $sql1->bindParam(':a', $id_default);
            $sql1->execute();
            $status = $sql1->fetchAll();
            if($status[0][$resultenabled] == 0) {
                $sql2 = $conn->prepare("SELECT $votespartyid FROM $votescast");
                $sql2->execute();
                $userid = $sql2->fetchAll();
                $d = [];
                foreach($userid as $u){
                    array_push($d,$u[$votespartyid]);
                }
                $sql3 = $conn->prepare("SELECT $party_name FROM $party_table ORDER BY $party_id");
                $sql3->execute();
                $party = $sql3->fetchAll();
                $g = ["None of the above"];
                foreach($party as $p){
                    array_push($g,$s->decrypt($p[$party_name]));
                }
                $h = json_encode($g);
                $c = json_encode(array_count_values($d));
                echo '<script>var s = JSON.stringify(';
                echo "$c";
                echo ');</script>';
                echo '<script>var g = JSON.stringify(';
                echo "$h";
                echo ');</script>';
            } elseif($status[0][$resultenabled] == 1) {
                echo '<h1>Results are yet to be announced.</h1>';
            }
        }

        catch(PDOException $e)
            {
            	echo $e->getMessage();
            }
    ?>

    <script>
        function create_tr(a, b) {
            var x = document.createElement("TR");
            x.setAttribute("id", a);
            document.getElementById(b).appendChild(x);
        }

        function create_th(a, b) {
            var x = document.createElement("TH");
            var y = document.createTextNode(a);
            x.appendChild(y);
            document.getElementById(b).appendChild(x);
        }

        function create_td(a, b) {
            var x = document.createElement("TD");
            var y = document.createTextNode(a);
            x.appendChild(y);
            document.getElementById(b).appendChild(x);
        }
        var h = JSON.parse(s);
        var q = JSON.parse(g);
        var m = 0;
        var s = 0;

        var u1 = [];
        for (var i = 0; i < q.length; i++) {
            var d = "";
            d += i;
            if (typeof (h[d]) === "undefined" || typeof (h[d]) === null) { u1[i] = 0; } else { u1[i] = h[d]; }
        }

        var a = [];
        for (var i = 0; i < q.length; i++) {
            b = [];
            b[0] = q[i];
            b[1] = u1[i];
            a[i] = b;
        }
        for (var i = 0; i < q.length; i++) {
            for (var j = 0; j < i; j++) {
                if (a[i][1] > a[j][1]) {
                    var x = a[i];
                    a[i] = a[j];
                    a[j] = x;
                }
            }
        }

        for (var i = 0; i < a.length; i++) {
            var r = "id"; r += i;
            create_tr(r, "table1");
            create_th(a[i][0], r);
            create_td(a[i][1], r);
        }

    </script>
</body>

</html>
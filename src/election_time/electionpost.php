<?php
	error_reporting(0);
	session_start();
?>

<?php
    if(empty($_SESSION['votername'])) {
        echo '<script>window.location.replace("../main.html");</script>';
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/virtualelection.css">
    <title>Virtual Elections</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            background-color: inherit;
            text-align: center;
            font-size: 1em;
            color: inherit;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <header class="appbar">Virtual Election</header>
    <div id="mainbody" class="mainbody">
        <h1>Hello, <span id="votername"></span>!</h1>
        <script>
            document.getElementById("votername").innerHTML = sessionStorage.getItem("votername"); 
        </script>
        <h1>Are you really sure that you want to vote for the following party / none of the above :</h1>
        <form action="cast_vote.php" method="post">
            <center>
                <input readonly name="myinput" id="myinput" style="font-size:1em; width: 80%;">
            </center>
            <br>
            <center>
                <input type="submit" name="save" value="YES, FINALIZE CASTED VOTE" class="submitbtn" style="width: 80%;">
            </center>
        </form>
        <br>
        <script>
            document.getElementById("myinput").value = sessionStorage.getItem("voted");
        </script>
        <center>
            <button class="submitbtn" onclick="javascript:window.location.href='election.php';" style="width: 80%;">NO, GO BACK</button>
        </center>
    </div>
</body>

</html>
<?php
	error_reporting(0);
	session_start();
?>

<?php
	if(!empty($_SESSION['alt'])) {
		if(!hash_equals($_SESSION['token'], $_SESSION['alt'])) {
			header('location: ../../public/oops/corrections_userinput.html');
		}
	} else {
		header('location: ../../public/oops/403.html');
	}
    $token = $_SESSION['alt'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../public/controllers/css.js"></script>
    <script>
        loadCSS(2);
    </script>
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
        #myinput {
            font-size: 1.5em;
            width: 78%;
            padding: 1% 1%;
        }
        .submitbtn {
            font-size: 1.75em;
            width: 80%;
            padding: 0.5% 0.5%;
        }
        .nodisplay {
            display: none;
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
        <form action="../controllers/cast_vote.php" method="post">
            <center>
                <input readonly name="myinput" id="myinput">
            </center>
            <br>
            <?php
                echo '<input type="password" class="nodisplay" name="token" id="token" value="';
                echo $token;
                echo '">';
            ?>
            <br>
            <center>
                <input type="submit" name="save" value="YES, FINALIZE VOTE" class="submitbtn">
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
<?php

    error_reporting(0);
    session_start();

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
    <title>Vote failed</title>
    <style>
        input[type=submit] {
            font-size: 0.8em;
        }

        .text-padded {
            padding: 0.5% 0.5%;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Calibri", "roboto", "helvetica", "arial", sans-serif;
            font-size: 1.35em;
        }
    </style>
</head>

<body>
    <header class="appbar">
        Vote failed
    </header>
    <div id="mainbody" class="mainbody">
        <div class="text-padded">
            Your vote was not cast successfully. This might be due to one or more of the following reason(s):
            <ul>
                <li>The service is temporarily down or unavailable.</li>
            </ul>
        </div>
        <h1 class="center-text">
            <form action="election.php" method="POST">
                <input type="submit" value="Try again">
            </form>
        </h1>
    </div>
</body>

</html>
<?php

    error_reporting(0);
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <script src="../../public/controllers/css.js"></script>
        <script>
            loadCSS(2);
        </script>
        <title>Vote failed</title>
        <link
            rel="stylesheet"
            type="text/css"
            href="../../public/fa/css/font-awesome-exclamation-circle.css"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="../../public/css/tos_warning.css"
        />
        <style>
            input[type="submit"] {
                font-size: 0.8em;
                min-width: 25vw;
            }

            .text-padded {
                padding: 0.5% 0.5%;
                font-size: 1.35em;
            }
        </style>
    </head>

    <body>
        <header class="appbar">Vote failed</header>
        <h1 class="appbar violated_appbar">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            <span class="violated_text"
                >Vote Unsuccessful | Service Unavailable</span
            >
        </h1>
        <div id="mainbody" class="mainbody">
            <div class="text-padded">
                Your vote was not cast successfully. This might be due to one or
                more of the following reason(s):
                <ul>
                    <li>The service is temporarily down or unavailable.</li>
                </ul>
            </div>
            <h1 class="center-text">
                <form action="../main/election.php" method="POST">
                    <input type="submit" value="Try again" />
                </form>
            </h1>
        </div>
    </body>
</html>

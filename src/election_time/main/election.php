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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <script src="../../public/controllers/css.js"></script>
        <script>
            loadCSS(2);
        </script>
        <title>Virtual Elections</title>
        <style>
            table,
            th,
            td {
                border: 1px solid #888888;
                background-color: inherit;
                text-align: center;
                font-size: 1.2em;
                color: inherit;
            }
            button {
                font-size: 0.7em;
            }
            .fullwidth {
                width: 100%;
            }
        </style>
    </head>

    <body>
        <header class="appbar">Virtual Election</header>
        <div id="mainbody" class="mainbody">
            <h1>Hello, <span id="votername"></span>!</h1>
            <script>
                document.getElementById("votername").innerHTML =
                    sessionStorage.getItem("votername");
            </script>
            <h1>Cast your vote:</h1>
            <table class="fullwidth" id="table1"></table>
            <script>
                var voted = "";
                var s = JSON.parse(sessionStorage.getItem("parties"));

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

                function create_td_btn(a, b, s) {
                    var x = document.createElement("TD");
                    var d = document.createElement("BUTTON");
                    d.innerHTML = "Vote for " + s[a][0];
                    d.onclick = function () {
                        voted = s[a][0];
                        sessionStorage.setItem("voted", s[a][0]);
                        window.location.href = "electionpost.php";
                    };
                    x.appendChild(d);
                    document.getElementById(b).appendChild(x);
                }

                create_tr("ig1", "table1");
                create_th("Party", "ig1");
                create_th("Candidate", "ig1");
                for (var i = 0; i < s.length; i++) {
                    var j = "id";
                    j += i;
                    create_tr(j, "table1");
                    create_td(s[i][0], j);
                    create_td(s[i][1], j);
                    create_td_btn(i, j, s);
                }
            </script>
        </div>
    </body>
</html>

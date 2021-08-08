<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database Setup</title>
    <script src="../../public/controllers/css.js"></script>
    <script>
        loadCSS(2);
    </script>
    <style>
        p1 {
            font-size: 1.25em;
            padding: 0;
        }

        .text-padded {
            padding: 1% 1%;
            font-size: 1.4em;
        }
    </style>
</head>

<body>
    <h1>
        Database Setup
    </h1>
    <div class="text-padded">
        <?php
            require_once '../config/dbconfig.php';
            require_once '../controllers/tablesetup.php';

            echo 'Setting up a virtual election database...<br>';
            $progresslevel = 1;
            try {
                $conn = new Connection();
                $conn->createDatabase();
                $progresslevel = 2;
            } catch(Exception $e) {
                echo 'Setup failed: Failed to create the database.';
            }
            if($progresslevel == 2) {
                echo '<br>';
                $t = new TableSetup();
                $c = 0;
                try {
                    $t->createAdminTable();
                    $c = $c + 1;
                } catch(Exception $e) {
                    echo 'Setup failed: Admin table was not created successfully.';
                }
                echo '<br>';
                try {
                    $t->createVoterTable();
                    $c = $c + 1;
                } catch(Exception $e) {
                    echo 'Setup failed: Voter table was not created successfully.';
                }
                echo '<br>';
                try {
                    $t->createVotesList();
                    $c = $c + 1;
                } catch(Exception $e) {
                    echo 'Setup failed: Votes structure was not created successfully.';
                }
                echo '<br>'; 
                try {  
                    $t->createPartyTable();
                    $c = $c + 1;
                } catch(Exception $e) {
                    echo 'Setup failed: Voter table was not created successfully.';
                }
                echo '<br>';
                if($c == 4) {
                    $progresslevel = 3;
                }
            }
            if($progresslevel == 3) {
                echo 'Setup completed. <br>It is recommended that you close this browser window for security reasons.';
            }
        ?>
    </div>
</body>
</html>
<?php
    require_once 'dbconfig.php';
    require_once 'tablesetup.php';

    echo 'Setting up a virtual election database...<br>';
    $conn = new Connection();
    $conn->createDatabase();
    $t = new TableSetup();
    $t->createAdminTable();
    $t->createVoterTable();
    $t->createVotesList();    
    $t->createPartyTable();
    echo 'Setup completed. <br>It is recommended that you close this browser window for security reasons.';
?>
<?php

    require_once "../controllers/controlelection.php";

    $o = new OpenCloseModules();
    if(isset($_POST["save"])) {
        $o->updateAll($_POST["voter"], $_POST["party"], $_POST["votecast"], $_POST["results"]);
    }

    header("Location: controller.php");

?>
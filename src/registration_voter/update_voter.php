<?php

	require '../db/dbconfig.php';
	require '../db/tablesconfig.php'; 
    require '../controllers/post_validate.php';  

    session_start();

    $tables = new Table();
	$voter_table = $tables->getVoterList();
	$voter = $voter_table["table"];
    $voter_id = $voter_table["id"];
	$voter_name = $voter_table["voter_name"];
	$voter_dob = $voter_table["voter_dob"];
	$voter_idno = $voter_table["idproof_value"];
	$voter_idproof = $voter_table["idproof_type"];
	$voter_gender = $voter_table["voter_gender"];
	$password = $voter_table["password"];

	$dbconn = new Connection();
	$conn = $dbconn->openConnection();

    $step = -1;

    try {
        if($_POST['cpd1'] == $_POST['cpd2']) {
            $step = 0;
        } else {
            throw new Exception("Passwords do not match!");
        }
    } catch(Exception $e) {

    }

    try {
        if($step == 0) {
            $data = $_SESSION["data"];
            $voterid = $data["voterid"];
            $cname = validateName(validateDatatype($_POST['cname'], 'string'));
            $cdob = validateDatatype($_POST['cdob'], 'ANY');
            $citype = validateName(validateDatatype($_POST['citype'], 'string'));
            $cidno = validateName(validateDatatype($_POST['cidno'], 'string'));
            $cgender = validateName(validateDatatype($_POST['cgender'], 'string'));
            $cpd = validateDatatype($_POST['cpd1'], 'ANY');
            $cpd1 = password_hash($cpd, PASSWORD_DEFAULT);
            $step = 1;
        } else {
            throw new Exception("Update aborted");
        }
    } catch(Exception $e) {

    }

    try {
        if($step != 1) {
            throw new Exception("Update aborted by user.");
        } else {
            $name = $data["name"];
            if(strcmp($cname, $name) != 0) {
                $sql1 = $conn->prepare("UPDATE $voter SET $voter_name = :cname WHERE $voter_id = :voterid");
                $sql1->bindParam(':cname', $cname, PDO::PARAM_STR, 100);
                $sql1->bindParam(':voterid', $voterid, PDO::PARAM_INT);
                $sql1->execute();
            }
            $step = 2;
        }
    } catch(Exception $e) {

    }

    try {
        if($step != 2) {
            throw new Exception("Update aborted by user.");
        } else {
            $dob = $data["dob"];
            if($cdob != $dob) {
                $sql2 = $conn->prepare("UPDATE $voter SET $voter_dob = :cdob WHERE $voter_id = :voterid");
                $sql2->bindParam(':cdob', $cdob);
                $sql2->bindParam(':voterid', $voterid, PDO::PARAM_INT);
                $sql2->execute();
            }
            $step = 3;
        }
    } catch(Exception $e) {
        
    }

    try {
        if($step != 3) {
            throw new Exception("Update aborted by user.");
        } else {
            $idtype = $data["idtype"];
            if(strcmp($citype, $idtype) != 0) {
                $sql3 = $conn->prepare("UPDATE $voter SET $voter_idproof = :citype WHERE $voter_id = :voterid");
                $sql3->bindParam(':citype', $citype, PDO::PARAM_STR, 20);
                $sql3->bindParam(':voterid', $voterid, PDO::PARAM_INT);
                $sql3->execute();
            }
            $step = 4;
        }
    } catch(Exception $e) {

    }

    try {
        if($step != 4) {
            throw new Exception("Update aborted by user.");
        } else {
            $idno = $data["idno"];
            if(strcmp($cidno, $idno) != 0) {
                $sql4 = $conn->prepare("UPDATE $voter SET $voter_idno = :cidno WHERE $voter_id = :voterid");
                $sql4->bindParam(':cidno', $cidno, PDO::PARAM_STR, 50);
                $sql4->bindParam(':voterid', $voterid, PDO::PARAM_INT);
                $sql4->execute();
            }
            $step = 5;
        }
    } catch(Exception $e) {

    }    

    try {
        if($step != 5) {
            throw new Exception("Update aborted by user.");
        } else {
            $gender = $data["gender"];
            if(strcmp($cgender, $gender) != 0) {
                $sql5 = $conn->prepare("UPDATE $voter SET $voter_gender = :cgender WHERE $voter_id = :voterid");
                $sql5->bindParam(':cgender', $cgender, PDO::PARAM_STR, 6);
                $sql5->bindParam(':voterid', $voterid, PDO::PARAM_INT);
                $sql5->execute();
            }
            $step = 6;
        }
    } catch(Exception $e) {

    }

    try {
        if($step != 6) {
            throw new Exception("Update aborted by user.");
        } else {
            $pwd = $data["password"];
            if(strcmp($cpd, $pwd) != 0) {
                $sql6 = $conn->prepare("UPDATE $voter SET $password = :cpd WHERE $voter_id = :voterid");
                $sql6->bindParam(':cpd', $cpd1);
                $sql6->bindParam(':voterid', $voterid, PDO::PARAM_INT);
                $sql6->execute();
            }
            $step = 7;
        }
    } catch(Exception $e) {

    }

    if($step == 7) {
        header('Location: registration_success.html');
    } else {
        header('Location: profile_edit_login.html');
    }
?>
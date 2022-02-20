<?php
    require_once '../../db/config/dbconfig.php';
    require_once '../../db/config/tablesconfig.php';
    require_once '../../db/controllers/ssl.php';

    function generateResults() {
        $c = new Connection();
        $conn = $c->openConnection();
        $t = new Table();
        $turnout = $t->getGenderTurnout();
        $crypto = new SecureData();
        $tname = $turnout["table"];
        $tnametype = $turnout["id"];
        $m = $turnout["male"];
        $f = $turnout["female"];
        $o = $turnout["other"];
        $g = $turnout["total"];
        $votes = $t->getVotes();
        $tvotes = $votes["table"];
        $tvotesv = $votes["voter"];
        $tvotesp = $votes["party"];
        $voter = $t->getVoterList();
        $tvoter = $voter["table"];
        $tvoterid = $voter["id"];
        $tvotergender = $voter["voter_gender"];
        $tresult = $t->getResults();
        $tresultn = $tresult["table"];
        $tresulti = $tresult["party"];
        $tresultc = $tresult["count"];

        $gendermapping = array(
            "Male" => $m,
            "Female" => $f,
            "Other" => $o
        );

        $genderAllMapping = array(
            $m => 0,
            $f => 0,
            $o => 0,
            $g => 0
        );

        $genderCompositionMapping = array(
            $m => 0,
            $f => 0,
            $o => 0,
            $g => 0
        );

        // Reset all values
        $sql1 = $conn->prepare(
            "UPDATE $tname SET $m=?, $f=?, $o=?, $g=?"
        );
        $sql1->execute([0, 0, 0, 0]);

        // Get all votes
        $sql2 = $conn->prepare("SELECT * FROM $tvotes");
        $sql2->execute();
        $votelist = $sql2->fetchAll();
        
        $voters = array();
        $contestants = array();

        // Record Gender Turnout
        foreach ($votelist as $v) {
            $vid = $crypto->decrypt($v[$tvotesv]);
            $sql3 = $conn->prepare(
                "SELECT $tvotergender FROM $tvoter WHERE $tvoterid = :vid"
            );
            $sql3->bindParam(':vid', $vid, PDO::PARAM_STR);
            $sql3->execute();
            $r = $sql3->fetchAll();
            $rgender = $r[0][$tvotergender];
            $sgender = $crypto->decrypt($rgender);
            array_push($voters, $gendermapping[$sgender]);
        }

        // Record Candidates
        foreach ($votelist as $v) {
            $cid = $crypto->decrypt($v[$tvotesp]);
            if (array_key_exists($cid, $contestants)) {
                $contestants[$cid] += 1;
            } else {
                $contestants[$cid] = 1;
            }
        }

        // Generate Turnout
        foreach($voters as $vs) {
            $genderAllMapping[$g] += 1;
            $genderCompositionMapping[$g] += 1;
            $genderAllMapping[$vs] += 1;
            $genderCompositionMapping[$vs] += 1;
        }

        // Save Turnout
        $sqlt1 = $conn->prepare(
            "UPDATE `$tname` SET `$m`=?, `$f`=?, `$o`=?, `$g`=? WHERE `$tnametype`=?"
        );
        $sqlt1->execute([
            $genderAllMapping[$m],
            $genderAllMapping[$f],
            $genderAllMapping[$o],
            $genderAllMapping[$g],
            "gender_all"
        ]);
        $sqlt2 = $conn->prepare(
            "UPDATE `$tname` SET `$m`=?, `$f`=?, `$o`=?, `$g`=? WHERE `$tnametype`=?"
        );
        $sqlt2->execute([
            $genderCompositionMapping[$m],
            $genderCompositionMapping[$f],
            $genderCompositionMapping[$o],
            $genderCompositionMapping[$g],
            "gender_composition"
        ]);

        // Generate Results
        try {
            $sqlr = $conn->prepare(
                "TRUNCATE TABLE `$tresultn`"
            );
            $sqlr->execute();
        } catch(Exception $e) {
        }
        $contestant_keys = array_keys($contestants);
        foreach ($contestant_keys as $votecount) {
            $sql4 = $conn->prepare(
                "INSERT INTO `$tresultn` (`$tresulti`, `$tresultc`) VALUES (:i, :c)"
            );
            $sql4->bindParam(':i', $crypto->encrypt($votecount));
            $sql4->bindParam(':c', $contestants[$votecount]);
            $sql4->execute();
        }
    }

    generateResults();
    header('location: ../mainmenu.html');
?>
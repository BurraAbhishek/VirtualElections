<?php
    require_once '../config/dbconfig.php';
    require_once '../config/tablesconfig.php';
    require_once '../controllers/ssl.php';

    class TableSetup
    {
        public function createAdminTable() {
            try {
                $conn1 = new Connection();
                $c1 = $conn1->openConnection();
                $t_global = new Table();
                $t = $t_global->getAdminStatus();
                $table = $t["table"];
                $i = $t["id"];
                $v = $t["voter"];
                $p = $t["party"];
                $e = $t["votecast"];
                $r = $t["results"];
                $pwd = $t["password"];
                $username = $t["id_default"];
                $pwd_default = password_hash(
                    $t["password_default"], 
                    PASSWORD_DEFAULT
                );
                $sqlCreate = $c1->prepare("CREATE TABLE `$table` (
                    `$i` varchar(100) NOT NULL DEFAULT '$username',
                    `$v` int(11) NOT NULL DEFAULT 0,
                    `$p` int(11) NOT NULL DEFAULT 0,
                    `$e` int(11) NOT NULL DEFAULT 0,
                    `$r` int(11) NOT NULL DEFAULT 0,
                    `$pwd` varchar(256) NOT NULL DEFAULT '$pwd_default'
                    );");
                $sqlCreate->execute();
                echo 'Admin table structure created.<br>';
                $sqlAlter = $c1->prepare(
                    "ALTER TABLE `$table` ADD PRIMARY KEY (`$i`);"
                );
                $sqlAlter->execute();
                echo 'Admin table created.<br>';
                $sqlInsert = $c1->prepare(
                    "INSERT INTO $table ($i, $v, $p, $e, $r, $pwd) 
                    VALUES (:username, 0, 0, 0, 0, :pwd)"
                );
                $sqlInsert->bindParam(':username', $username);
                $sqlInsert->bindParam(':pwd', $pwd_default);
                $sqlInsert->execute();
                echo 'Admin table is ready.<br>';
            } catch(Exception $e) {
                echo 'The admin table either exists or is corrupted<br>';
            }
        }

        public function createControlsTable() {
            try {
                $conn1 = new Connection();
                $c1 = $conn1->openConnection();
                $t_global = new Table();
                $t = $t_global->getControls();
                $table = $t["table"];
                $i = $t["id"];
                $vl = $t["localize"];
                $vp = $t["showprofile"];
                $vt = $t["showviolations"];
                $vv = $t["mustvote"];
                $va = $t["voterage"];
                $vab = $t["voteragemin"];
                $vad = $t["voteragemax"];
                $vc = $t["candidateage"];
                $vcb = $t["candidateagemin"];
                $vcd = $t["candidateagemax"];
                $sqlCreate = $c1->prepare("CREATE TABLE `$table` (
                    `$i` INT NOT NULL DEFAULT '0' ,
                    `$vl` BOOLEAN NOT NULL DEFAULT TRUE , 
                    `$vp` INT NOT NULL DEFAULT '1' , 
                    `$vt` BOOLEAN NOT NULL DEFAULT TRUE , 
                    `$vv` BOOLEAN NOT NULL DEFAULT FALSE , 
                    `$va` BOOLEAN NOT NULL DEFAULT FALSE , 
                    `$vab` INT NOT NULL DEFAULT '0' , 
                    `$vad` INT NOT NULL DEFAULT '100' , 
                    `$vc` BOOLEAN NOT NULL DEFAULT FALSE , 
                    `$vcb` INT NOT NULL DEFAULT '0' , 
                    `$vcd` INT NOT NULL DEFAULT '100'
                );");
                $sqlCreate->execute();
                echo 'Controls table structure created.<br>';
                $sqlAlter = $c1->prepare(
                    "ALTER TABLE `$table` ADD PRIMARY KEY (`$i`);"
                );
                $sqlAlter->execute();
                echo 'Controls table created.<br>';
                $true = true;
                $false = false;
                $sqlInsert = $c1->prepare(
                    "INSERT INTO `$table` 
                    (`$i`,`$vl`,`$vp`,`$vt`,`$vv`,`$va`,`$vab`,`$vad`,`$vc`,`$vcb`,`$vcd`) 
                    VALUES ('0',:vl,'1',:vt,:vv,:va,'0','100',:vc,'0','100')"
                );
                $sqlInsert->bindParam(':vl', $true, PDO::PARAM_BOOL);
                $sqlInsert->bindParam(':vt', $true, PDO::PARAM_BOOL);
                $sqlInsert->bindParam(':vv', $false, PDO::PARAM_BOOL);
                $sqlInsert->bindParam(':va', $false, PDO::PARAM_BOOL);
                $sqlInsert->bindParam(':vc', $false, PDO::PARAM_BOOL);
                $sqlInsert->execute();
                echo 'Controls table is ready.<br>';
            } catch(Exception $e) {
                echo 'The controls table either exists or is corrupted<br>';
            }
        }

        public function createVoterTable() {
            try {
                $conn2 = new Connection();
                $c2 = $conn2->openConnection();
                $t_global = new Table();
                $t = $t_global->getVoterList();
                $table = $t["table"];
                $i = $t["id"];
                $n = $t["voter_name"];
                $g = $t["voter_gender"];
                $d = $t["voter_dob"];
                $k = $t["idproof_type"];
                $v = $t["idproof_value"];
                $p = $t["password"];
                $sqlCreate = $c2->prepare("CREATE TABLE `$table` (
                    `$i` varchar(12) NOT NULL,
                    `$n` varchar(256) NOT NULL,
                    `$g` varchar(128) NOT NULL,
                    `$d` varchar(256) NOT NULL,
                    `$k` varchar(256) NOT NULL,
                    `$v` varchar(256) NOT NULL,
                    `$p` varchar(256) NOT NULL
                  );");
                $sqlCreate->execute();
                $sqlAlter1 = $c2->prepare("ALTER TABLE `$table` 
                    ADD PRIMARY KEY (`$i`),
                    ADD UNIQUE KEY `$k` (`$k`,`$v`);");
                $sqlAlter1->execute();
                echo 'The voter table is ready<br>';
            } catch(Exception $e) {
                echo 'The voter table either exists or is corrupted<br>';
            }
        }

        public function createVotesList() {
            try {
                $conn3 = new Connection();
                $c3 = $conn3->openConnection();
                $t_global = new Table();
                $t = $t_global->getVotes();
                $votertable = $t_global->getVoterList();
                $votername = $votertable["table"];
                $voterid = $votertable["id"];
                $table = $t["table"];
                $v = $t["voter"];
                $p = $t["party"];
                $sqlCreate = $c3->prepare("CREATE TABLE `$table` (
                    `$v` varchar(256) NOT NULL,
                    `$p` varchar(256) NOT NULL
                    );");
                $sqlCreate->execute();
                $sqlAlter1 = $c3->prepare("ALTER TABLE `$table` 
                    ADD PRIMARY KEY (`$v`);");
                $sqlAlter1->execute();
                echo 'Votes table structure created<br>';                
            } catch(Exception $e) {
                echo 'The votes structure either exists or is corrupted<br>';
            }
        }


        public function createPartyTable() {
            try {
                $conn4 = new Connection();
                $c4 = $conn4->openConnection();
                $t_global = new Table();
                $t = $t_global->getPartyList();
                $crypto = new SecureData();
                $nota_id = "00000000";
                $nota_name = $crypto->encrypt("None Of The Above");
                $nota_iid = $crypto->encrypt("00000000");
                $table = $t["table"];
                $i = $t["id"];
                $n = $t["party_name"];
                $c = $t["candidate_name"];
                $d = $t["idproof_type"];
                $v = $t["idproof_value"];
                $sqlCreate = $c4->prepare("CREATE TABLE `$table` (
                    `$i` varchar(8) NOT NULL,
                    `$n` varchar(512) NOT NULL,
                    `$c` varchar(512) NOT NULL,
                    `$d` varchar(256) NOT NULL,
                    `$v` varchar(256) NOT NULL
                );");
                $sqlCreate->execute();
                echo 'Contestant table structure created<br>';
                $sqlAlter1 = $c4->prepare("ALTER TABLE `$table` 
                    ADD PRIMARY KEY (`$i`),
                    ADD UNIQUE KEY `$n` (`$n`),
                    ADD UNIQUE KEY `$d` (`$d`,`$v`)
                    ;");
                $sqlAlter1->execute();
                echo 'Contestant table created<br>';
                $sqlInsert = $c4->prepare(
                    "INSERT INTO `$table` (`$i`, `$n`, `$c`, `$d`, `$v`) 
                    VALUES (:i, :n, :c, :d, :v)"
                );
                $sqlInsert->bindParam(':i', $nota_id, PDO::PARAM_STR, 8);
                $sqlInsert->bindParam(':n', $nota_name, PDO::PARAM_STR);
                $sqlInsert->bindParam(':c', $nota_name, PDO::PARAM_STR);
                $sqlInsert->bindParam(':d', $nota_name, PDO::PARAM_STR);
                $sqlInsert->bindParam(':v', $nota_iid, PDO::PARAM_STR);
                $sqlInsert->execute();
                echo 'Contestant table ready<br>';
            } catch(Exception $e) {
                echo 'The contestant table either exists or is corrupted<br>';
            }
        }
    }
?>

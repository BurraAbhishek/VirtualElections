<?php
    require_once '../config/dbconfig.php';
    require_once '../config/tablesconfig.php';

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
                $pwd_default = password_hash($t["password_default"], PASSWORD_DEFAULT);
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
                $sqlAlter = $c1->prepare("ALTER TABLE `$table` ADD PRIMARY KEY (`$i`);");
                $sqlAlter ->execute();
                echo 'Admin table created.<br>';
                $sqlInsert = $c1->prepare("INSERT INTO $table ($i, $v, $p, $e, $r, $pwd) VALUES (:username, 0, 0, 0, 0, :pwd)");
                $sqlInsert->bindParam(':username', $username);
                $sqlInsert->bindParam(':pwd', $pwd_default);
                $sqlInsert->execute();
                echo 'Admin table is ready.<br>';
            } catch(Exception $e) {
                echo 'The administration table either exists or is corrupted<br>';
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
                    `$i` int(11) NOT NULL,
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
                $sqlAlter2 = $c2->prepare("ALTER TABLE `$table` 
                    MODIFY `$i` int(11) NOT NULL AUTO_INCREMENT;");
                $sqlAlter2->execute();
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
                    `$v` int(11) NOT NULL DEFAULT 0,
                    `$p` int(11) NOT NULL DEFAULT 0
                    );");
                $sqlCreate->execute();
                $sqlAlter1 = $c3->prepare("ALTER TABLE `$table` ADD PRIMARY KEY (`$v`);");
                $sqlAlter1->execute();
                $sqlAlter2 = $c3->prepare("ALTER TABLE `$table` ADD CONSTRAINT `election_ibfk_1` 
                    FOREIGN KEY (`$v`) 
                    REFERENCES `$votername` (`$voterid`);");
                $sqlAlter2->execute();
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
                $table = $t["table"];
                $i = $t["id"];
                $n = $t["party_name"];
                $c = $t["candidate_name"];
                $d = $t["idproof_type"];
                $v = $t["idproof_value"];
                $sqlCreate = $c4->prepare("CREATE TABLE `$table` (
                    `$i` int(11) NOT NULL,
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
                $sqlAlter2 = $c4->prepare("ALTER TABLE `$table` 
                    MODIFY `$i` int(11) NOT NULL AUTO_INCREMENT;");
                $sqlAlter2->execute();
                echo 'Contestant table ready<br>';
            } catch(Exception $e) {
                echo 'The contestant table either exists or is corrupted<br>';
            }
        }
    }
?>
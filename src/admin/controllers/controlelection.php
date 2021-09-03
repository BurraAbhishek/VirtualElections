<?php

    error_reporting(0);

    require_once '../../db/config/dbconfig.php';
    require_once '../../db/config/tablesconfig.php';

    try {
        $temp_dbconn = new Connection();
        $temp_conn = $temp_dbconn->openConnection();
        $temp_conn = null;
    } catch (Exception $e) {
        header('location: ../../public/oops/503.html');
    }

    class OpenCloseModules {
        private $isvoterregistrationclosed;
        private $ispartyregistrationclosed;
        private $isvotingclosed;
        private $isresultclosed;
        private function getFromDatabase() {
            $tables = new Table();
            $admin = $tables->getAdminStatus();
            $admin_table = $admin["table"];
            $voter = $admin["voter"];
            $party = $admin["party"];
            $votescast = $admin["votecast"];
            $results = $admin["results"];
            $admin_id = $admin["id"];
            $id_default = $admin["id_default"];
            $dbconn = new Connection();
            $conn = $dbconn->openConnection();
            $sql = $conn->prepare(
                "SELECT * FROM $admin_table WHERE $admin_id = :a"
            );
            $sql->bindParam(':a', $id_default);
            $sql->execute();
            $result = $sql->fetchAll();
            $this->isvoterregistrationclosed = $result[0][$voter];
            $this->ispartyregistrationclosed = $result[0][$party];
            $this->isvotingclosed = $result[0][$votescast];
            $this->isresultclosed = $result[0][$results];
        }
        private function updateAvailability($attr, $value) {
            if($value == 0 || $value == 1 || $value == "0" || $value == "1") {
                if($value == 0 || $value == "0") {
                    $v = 0;
                } else if($value == 1 || $value == "1") {
                    $v = 1;
                }
                $dbconn = new Connection();
                $conn = $dbconn->openConnection();
                $tables = new Table();
                $admin = $tables->getAdminStatus();
                $admin_table = $admin["table"];
                $admin_id = $admin["id"];
                $id_default = $admin["id_default"];
                $sql = $conn->prepare(
                    "UPDATE $admin_table SET $attr = :val WHERE $admin_id = :a"
                );
                $sql->bindParam(':val', $v, PDO::PARAM_INT);
                $sql->bindParam(':a', $id_default);
                $sql->execute();
            }
        }
        public function showCurrentStatus() {
            $t = array(
                "0" => $this->isvoterregistrationclosed,
                "1" => $this->ispartyregistrationclosed,
                "2" => $this->isvotingclosed,
                "3" => $this->isresultclosed,
            );
            return $t;
        }
        public function accessAdminPortal() {
            try {
                $this->getFromDatabase();
            } catch(Exception $e) {
                echo "<h2> Please create a new instance of the ";
                echo "election database before proceeding further </h2>";
            }
        }
        public function updateAll($v, $p, $e, $r) {
            $tables = new Table();
            $admin = $tables->getAdminStatus();
            $voter = $admin["voter"];
            $party = $admin["party"];
            $votescast = $admin["votecast"];
            $results = $admin["results"];
            $this->updateAvailability($voter, $v);
            $this->updateAvailability($party, $p);
            $this->updateAvailability($votescast, $e);
            $this->updateAvailability($results, $r);
        }
    }


?>
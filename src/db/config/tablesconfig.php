<?php
    /**
     * Contains the attributes of each table used in this database.
     * 
     * In each array:
     * <ul>
         *      <li> "table" maps to the name of the table which is created. </li>
         *      <li> "id" maps to a unique identification parameter </li>
         *      <li> passwords have plaintext values. These are hashed and sent to the database. </li>
         *      <li> The rest of the keys are self-explanatory. </li>
         * </ul>
         * 
     * @author Burra Abhishek
     * @license Apache License, Version 2.0
     * 
     */
    class Table
    {
        private $adminAttributes = array(
            "table" => "admin",
            "id_default" => "admin",
            "password_default" => 'test',
            "id" => "admin_id",
            "voter" => "voterregistrations",
            "party" => "partyregistrations",
            "votecast" => "votecasting",
            "results" => "results",
            "password"=> "password"
        );
        private $electionAttributes = array(
            "table" => "election",
            "voter" => "voter_id",
            "party" => "party_id"
        );
        private $partyAttributes = array(
            "table" => "parties",
            "id" => "party_id",
            "party_name" => "party_name",
            "candidate_name" => "candidate",
            "idproof_type" => "idproof",
            "idproof_value" => "idno"
        );
        private $voterAttributes = array(
            "table" => "voter",
            "id" => "voter_id",
            "voter_name" => "voter_name",
            "voter_gender" => "voter_gender",
            "voter_dob" => "dob",
            "idproof_type" => "idproof",
            "idproof_value" => "idno",
            "password" => "password"
        );
        public function getAdminStatus() {
            return $this->adminAttributes;
        }
        public function getVoterList() {
            return $this->voterAttributes;
        }
        public function getPartyList() {
            return $this->partyAttributes;
        }
        public function getVotes() {
            return $this->electionAttributes;
        }                        
    }
?>
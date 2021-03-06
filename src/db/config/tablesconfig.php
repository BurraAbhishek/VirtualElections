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
        private $controlAttributes = array(
            "table" => "controls",
            "id" => "order",
            "localize" => "allow_local",
            "showprofile" => "show_profile",
            "showviolations" => "show_tos_violation",
            "mustvote" => "candidate_must_vote",
            "voterage" => "voter_age_constraint",
            "voteragemin" => "voter_age_min",
            "voteragemax" => "voter_age_max",
            "candidateage" => "candidate_age_constraint",
            "candidateagemin" => "candidate_age_min",
            "candidateagemax" => "candidate_age_max"
        );
        private $electionAttributes = array(
            "table" => "election",
            "voter" => "voter_id",
            "party" => "party_id"
        );
        private $resultAttributes = array(
            "table" => "result",
            "party" => "id",
            "count" => "value"
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
        private $genderTurnoutAttributes = array(
            "table" => "turnout",
            "id" => "type",
            "male" => "male",
            "female" => "female",
            "other" => "other",
            "total" => "total"
        );
        public function getAdminStatus() {
            return $this->adminAttributes;
        }
        public function getControls() {
            return $this->controlAttributes;
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
        public function getGenderTurnout() {
            return $this->genderTurnoutAttributes;
        }
        public function getResults() {
            return $this->resultAttributes;
        }
    }
?>

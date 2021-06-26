<?php
    class Table
    {
        private $admin = 'admin';
        private $voter = 'voter';
        private $party = 'parties';
        public $votescast = 'election';
        public function getAdminStatus() {
            return $this->admin;
        }
        public function getVoterList() {
            return $this->voter;
        }
        public function getPartyList() {
            return $this->party;
        }
        public function getVotes() {
            return $this->votescast;
        }                        
    }
?>
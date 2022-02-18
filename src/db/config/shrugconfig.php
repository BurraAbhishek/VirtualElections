<?php
    /**
     * Generation of user ids for voters.
     * 
     * These user IDs can serve as primary keys
     */
    function generate_id($size) {
        $s = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $r = '';
        for ($i = 0; $i < $size; $i++) {
            $r .= substr(str_shuffle($s), 0, 1);
        }
        return $r;
    }
?>
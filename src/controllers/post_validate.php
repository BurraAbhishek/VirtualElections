<?php
    function validateDatatype($data, $requiredtype) {
        if(strcasecmp($requiredtype, "ANY") == 0) {
            $result = true;
        } else {
            $type = gettype($data);
            if(strcasecmp($requiredtype, $type) == 0){
                if(strcasecmp($type, "string") == 0){
                    if(strlen(trim($data)) > 0) {
                        $result = true;
                    } else {
                        $result = false;
                    }
                } else {
                    $result = true;
                }
            } else {
                $result = false;
            }
        }
        if($result) {
            return $data;
        } else {
            throw new Exception("Invalid user input");
        }
    }

    function validateID($givenID) {
        $regex = '/^(?!^0+$)[a-zA-Z0-9]{3,50}$/';
        $exception = 'Invalid Identity proof';
        if(preg_match($regex, $givenID)) {
            return (string)$givenID;
        } else {
            throw new Exception($exception);
        }
    }

    function validateName($givenName) {
        $restricted_chars = "!|@#$%^&*[]{}<>;?~:\/=";
        if(strpbrk($givenName, $restricted_chars)) {
            throw new Exception("Invalid name");
        } else {
            return (string)$givenName;
        }
    }
?>
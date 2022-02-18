<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../public/controllers/css.js"></script>
    <script>
        loadCSS(2);
    </script>
    <title>Voter Registration</title>
    <script src="../prevalidate/agecheck.js"></script>
</head>

<body>
    <header class="appbar">Voter Registration</header>

<?php
	require_once '../../db/config/dbconfig.php';
	require_once '../../db/config/tablesconfig.php';
    require_once '../../db/controllers/ssl.php';
    require_once '../../db/config/idconfig.php';

    try {
        $conn = new Connection();
        $open_conn = $conn->openConnection();
    } catch (Exception $e) {
        header('location: ../../public/oops/403.html');
    }

    class VoterData
    {
        private $voterid;
        private $name;
        private $dob;
        private $idtype;
        private $idno;
        private $gender;
        private $password;
        public $dbconn;
        public $tables;
        public function authenticateVoter($citype, $cidno, $pwd) {
            try {
                $this->dbconn = new Connection();
                $conn = $this->dbconn->openConnection();
                $s = new SecureData();
                $this->tables = new Table();
	            $voter_table = $this->tables->getVoterList();
                $voter = $voter_table["table"];
                $voter_id = $voter_table["id"];
                $voter_name = $voter_table["voter_name"];
                $dob = $voter_table["voter_dob"];
                $idno = $voter_table["idproof_value"];
                $idproof = $voter_table["idproof_type"];
                $gender = $voter_table["voter_gender"];
                $password = $voter_table["password"];
                $sql = $conn->prepare(
                    "SELECT * FROM $voter 
                    WHERE $idproof = :citype 
                    AND $idno = :cidno"
                );
                $sql->bindParam(':citype', $citype, PDO::PARAM_STR, 20);
                $sql->bindParam(':cidno', $cidno, PDO::PARAM_STR, 50);
                $sql->execute();
                $userid = $sql->fetchAll();
                foreach($userid as $u){
                    $u1 = $u[$idproof];
                    $u2 = $u[$idno];
                    $u3 = $u[$password];
                }
                if(
                    ($citype == $u1) 
                    && ($cidno == $u2) 
                    && (password_verify($pwd, $u3))
                ) {
                   $this->voterid = $userid[0][$voter_id];
                   $this->name = $s->decrypt($userid[0][$voter_name]);
                   $this->dob = $s->decrypt($userid[0][$dob]);
                   $this->idtype = $s->decrypt($userid[0][$idproof]);
                   $this->idno = $s->decrypt($userid[0][$idno]);
                   $this->gender = $s->decrypt($userid[0][$gender]);
                   $this->password = $pwd;
                   $_SESSION["data"] = array(
                       "voterid"=>$this->voterid,
                       "name"=>$this->name,
                       "dob"=>$this->dob,
                       "idtype"=>$this->idtype,
                       "idno"=>$this->idno,
                       "gender"=>$this->gender,
                       "password"=>$this->password,
                   );
                   $this->showInterface();
                } else {
                    throw new Exception("Incorrect Password");
                }
            } catch(Exception $e) {
                header("location: ../profile_edit_login.php");
            }
        }
        public function showInterface() {
            $id_proofs = new IDProof();
            $ids_list = $id_proofs->get_options($selected=$this->idtype);
            echo '<div id="mainbody" class="mainbody">
            <form action="update_voter.php" method="post" 
            onsubmit="javascript:return validateForm();">
                <p1>
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: right;">Voter\'s Name: </td>
                            <td><input type="text" name="cname" id="cname" 
                            pattern="[^/<>;:@#&%=[\]{\}\\\*\$!\?\/\|]+" 
                            title="Maximum 100 characters. 
                            The following characters are prohibited: 
                            !|@#$%^&*[]{}<>;?~:\/=" 
                            value="';
                            echo "$this->name";
                            echo '" required></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">Date of birth: </td>
                            <td><input type="date" name="cdob" id="cdob" value="';
                            echo "$this->dob";
                            echo '" required></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">Gender: </td>
                            <td><select name="cgender" id="cgender" 
                                onchange="javascript:changeToggle();">
                                    <option id="gender1" value="Male"';
                                    if($this->gender == "Male") {
                                        echo ' selected ';
                                    }
                                    echo '>Male</option>
                                    <option id="gender2" value="Female"';
                                    if($this->gender == "Female") {
                                        echo ' selected ';
                                    }
                                    echo '>Female</option>
                                    <option id="gender3" value="Other"';
                                    if($this->gender == "Other") {
                                        echo ' selected ';
                                    }
                                    echo '>Other</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">
                                <abbr title="Type of ID Proof, default is passport"
                                    style="text-decoration: none;">
                                    Identification type: </abbr></td>
                            <td><select name="citype" id="citype">'.$ids_list.'</select>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">Passport / ID Number: </td>
                            <td><input type="text" name="cidno" id="cidno" 
                            pattern="^(?!^0+$)[a-zA-Z0-9]{3,50}$" 
                            title="Only 3 to 50 characters. 
                            Only numbers, uppercase and lowercase. 
                            The sequence should not be all 0s." 
                            value="';
                            echo "$this->idno";
                            echo '" required></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">Enter Password: </td>
                            <td><input type="password" name="cpd1" id="cpd1" 
                                required value="';
                            echo "$this->password";
                            echo '"></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">Confirm Password: </td>
                            <td><input type="password" name="cpd2" id="cpd2" value="';
                            echo "$this->password";
                            echo '"></td>
                        </tr><tr style="display:none"><td colspan=2>
                            <input type="password" name="token" id="token" value="';
                        $token = $_SESSION['alt'];
                        echo $token;
                        echo '">
                        </td></tr><tr>
                            <td colspan=2 style="text-align: center;">
                                <input class="submitbtn" type="submit" 
                                value="Update Details"
                                    name="save"></td>
                        </tr>
                    </table>
                </p1>
            </form>
        </div>';
        echo '<script>
            document.getElementById("cgender1").value 
            = document.getElementById("cgender").value;
            function changeToggle() {
                for(var i = 1; i <= 3; i++) {
                    if(document.getElementById(
                        "gender" + i
                    ).hasAttribute("selected")) {
                        document.getElementById(
                            "gender" + i
                        ).removeAttribute("selected");
                    }
                }
                document.getElementById("cgender1").value 
                = document.getElementById("cgender").value;
            }
        </script>';
        }
    }
?>

</body>
</html>

<?php
	/**
     * The list of all allowed identity proof documents.
     * 
     * Data was taken from:
     * https://en.wikipedia.org/wiki/List_of_national_identity_card_policies_by_country
     * 
     * @author Burra Abhishek
	 * @license Apache License, Version 2.0
     * 
     */
    class IDProof
    {
        private $general = array(
            "Afghan Takzira",
            "Afghan Passport",
            "Albanian Identity Card",
            "Albanian Passport",
            "Algerian National Identity card",
            "Algerian Passport",
            "Andorran Passport",
            "Andorran Driving License",
            "Angolan national citizen identity card",
            "Angolan Passport",
            "Antiguan and Barbudan national identity card",
            "Antiguan and Barbudan Passport",
            "Documento Nacional de Identidad Argentina",
            "Argentine Passport",
            "Australian Passport (Issued by the Federal Government)",
            "Austrian Passport",
            "Austrian Identity Card",
            "Azerbaijani Identity Card",
            "Azerbaijani Passport",
            "Bahamas Passport",
            "Bahrain Central Population Register",
            "Bahraini Passport",
            "Bangladeshi NID Card",
            "Bangladeshi Passport",
            "Barbados Passport",
            "Belarusian Passport",
            "Belgian ID Card",
            "Belize Passport",
            "Benin National ID Card",
            "Bhutan Citizenship Card",
            "Bolivian ID Card",
            "Bolivian Passport",
            "Botswana Omang",
            "Botswana Passport",
            "Identity card of Bosnia and Herzegovina",
            "Passport of Bosnia and Herzegovina",
            "Brazilian ID Card",
            "Brazilian Driver's License (Federally Issued)",
            "Brazilian Passport",
            "Brunei ID Card",
            "Brunei Passport",
            "Bulgarian ID Card",
            "Bulgarian Passport",
            "Burkina Faso CNIB",
            "Burkina Faso Passport",
            "Cambodian Passport",
            "Khmer Identity Card",
            "Cameroon Passport",
            "Cameroon Driving License",
            "Cameroon Identity Card",
            "Canadian Passport",
            "Cape Verde Citizen Card",
            "Central African Republic Identity Card",
            "Chad National Identity Card",
            "Chile Documento de identidad",
            "Chinese Resident Identity Card",
            "Chinese Passport",
            "Colombian Passport",
            "Colombian Documento de identidad",
            "Comorian National Identity Card",
            "Congo National Identity Card",
            "Congo Passport",
            "Costa Rica Documento de identidad",
            "Costa Rican Passport",
            "Croatian Passport",
            "Croatian Citizen Identity Card",
            "Cuban Passport",
            "Cuba Carnet de identidad",
            "Cyprus Identity Card",
            "Cyprus Passport",
            "Czech Republic Passport",
            "Czech Republic Civil Card",
            "Danish (Denmark) Passport",
            "Djibouti Passport",
            "Djibouti National Identity Card",
            "Dominican Republic Underage Identity Card",
            "Dominican Republic Identity Card",
            "Egyptian Passport",
            "Egyptian Personality Verification Card",
            "El Salvador Passport",
            "El Salvador Unique Identity Card",
            "Ecuador Passport",
            "Ecuador Documento de identidad",
            "Equatorial Guinea Documento de Identidad Personal",
            "Eritrea National Identity Card",
            "Estonian Identity Card",
            "Ethiopian National Identity Card",
            "Finland Passport",
            "Finland Driving Licence",
            "Finland National Social Security Card",
            "French Passport",
            "Gabon National Identity Card",
            "Gambian National Identity Card",
            "Gambian Passport",
            "Georgian Passport",
            "Georgian National Identity Card",
            "German Passport",
            "German Identity Card",
            "Ghana Passport",
            "Ghana Card",
            "Gibraltar Identity Card",
            "Greek Identity Card",
            "Grenada Passport",
            "Grenada Voter Identity Card",
            "Guatemalan National Identity Document",
            "Guinea National Identity Card",
            "Guinea-Bissau Bilhete de identidade CEDEAO",
            "Guyana national identity card",
            "Haiti Passport",
            "Haiti Kat idantifikasyon nasyonal",
            "Honduras Documento de identidad",
            "Hong Kong Passport",
            "Hong Kong Identity Card",
            "Hungarian Passport",
            "Hungarian Driver's Licence",
            "Hungarian Identity Card",
            "Iceland Passport",
            "Indian Passport",
            "Indian ration card",
            "Indian PAN Card",
            "Indian Driving Licence",
            "Indian Aadhaar Card",
            "Indonesian Passport",
            "Indonesia Resident Identification Card",
            "Iranian National Identity Card",
            "Iraq National Card",
            "Irish (Ireland) Passport Card",
            "Israeli Passport",
            "Israel Teudat Zehut",
            "Italian Passport",
            "Italian electronic identity card",
            "Ivory Coast National Identity Card",
            "Ivory Coast Passport",
            "Jamaican Identity Card",
            "Japanese Passport",
            "Japanese Driving Licence",
            "Jordan Passport",
            "Jordan Personal Card",
            "Kazakhastan Identity Card",
            "Kenya Passport",
            "Kenya National Identification Card",
            "Kiribati Passport",
            "Kosovar National Identity Card",
            "Kuwaiti Civil ID Card",
            "Kyrgyzstan National Identity Card",
            "Laos Identity Card",
            "Latvian Identity Card",
            "Lebanese Identity Card",
            "Lesotho National ID Card",
            "Liberia National Identity Card",
            "Libyan Passport",
            "Lichenstein Passport",
            "Lichenstein Identity Card",
            "Lithuanian Passport",
            "Lithuanian Identity Card",
            "Luxembourg Passport",
            "Luxembourg National Identity Card",
            "Macau Bilhete de Identidade de Residente",
            "Madagascar Passport",
            "Madagascar Kara-panondrom-pirenena",
            "Malaysian Passport",
            "Malaysian MyPR",
            "Malaysian MyKas",
            "Malaysian MyKid",
            "Malaysian MyKad",
            "Malawi Passport",
            "Malawi National Identification Card",
            "Maldives Passport Card",
            "Mali NINA National identity card",
            "Malta Passport",
            "Malta Identity Card",
            "Marshall Islands Passport",
            "Mauritania Passport",
            "Mauritania National Identity Card",
            "Mauritius Passport",
            "Mauritius National Identity Card",
            "Mexican Passport",
            "Mexican Voters Identity Card",
            "Moldova Identity Card",
            "Morocco CNIE",
            "Monaco CIME",
            "Citizen Identity Card of Mongolia",
            "Montenegro Passport",
            "Montenegro Identity Card",
            "Mozambican Passport",
            "Mozambique Bilhete de identidade",
            "Myanmar NRC",
            "Namibia National ID Card",
            "Nauru Passport",
            "Nepal National Identity Card",
            "New Zealand Passport",
            "New Zealand Driving Licence",
            "New Zealand Kiwi Access Card",
            "Netherlands Passport",
            "Netherlands Identity Card",
            "Niger National Identity Card",
            "Nigeria National Identity Card",
            "North Korea Identity Card",
            "North Macedonia Identity Card",
            "Norwegian (Norway) Passport",
            "Oman Identity Card",
            "Panama Cedula de Identidad",
            "Pakistani Passport",
            "Pakistani CNIC",
            "Palau Passport",
            "Palestine Identity Card",
            "Palestine Passport",
            "Papua New Guinea National Identity Card",
            "Paraguayan National Identity Card",
            "Peru Documento Nacional de Identidad",
            "Philippine Identification Card",
            "Poland Identity Card",
            "Portuguese Passport",
            "Portugal Identity Card",
            "Portugal Citizen Card",
            "Qatari Passport",
            "Qatari Identity Card",
            "Romania Identity Card",
            "Internal Passport of Russia",
            "Rwandan National Identity Card",
            "Saint Kitts and Nevis Passport",
            "Saint Lucia Passport",
            "Saint Lucia Identity Card",
            "Saint Vincent And the Grenadines National Identity Card",
            "Samoa Passport",
            "San Marino Identity Card",
            "Sao Tome and Principe Bilhete de identidade",
            "Saudi Arabian Passport",
            "Saudi Arabian Iqama",
            "Serbian Passport",
            "Serbian Driving Licence",
            "Serbian Identity Card",
            "Serbian Refugee Identity Card",
            "Senegal CEDEAO",
            "Seychelles National Identity Card",
            "Sierra Leone National Identity Card",
            "Singapore Passport",
            "Singapore NRIC",
            "Slovakian Citizen Card",
            "Slovenian Identity Card",
            "Solomon Islands Passport",
            "Somalian Warqadda Aqoonsiga",
            "South African Passport",
            "South African Identity Card",
            "South Korean Identity Card",
            "Sudanese National Identity Card",
            "Surinamese Identiteitskaart",
            "Spanish DNI",
            "Sri Lankan Passport",
            "Sri Lankan National Identity Card",
            "Swaziland National ID Card",
            "Swedish Passport",
            "Swiss ID Card",
            "Switzerland Passport",
            "Syrian Passport",
            "Taiwanese National Identity Card",
            "Taiwanese Passport",
            "Tajikistan National Identity Card",
            "Thailand Passport",
            "Thai National Identity Card",
            "East Timor Bilhete de identidade",
            "Tonga Passport",
            "Tonga Driving Licence",
            "Tonga National Identity Card",
            "Trinidad and Tobago National Identity Card",
            "Tunisian Passport",
            "Tunisian National Identity Card",
            "Turkish Identity Card",
            "Turkmenistan Passport",
            "Tuvalu Passport",
            "Uganda National Identity Card",
            "Ukraine Passport",
            "UAE Passport",
            "Emirates ID",
            "United Kingdom (UK) Passport",
            "United Kingdom (UK) Driving Licence",
            "United States of America (US) Passport",
            "Uruguay Identity Card",
            "Uzbekistan National Identity Card",
            "Vanuatu Passport",
            "Venezuelan Passport",
            "Venezuelan Identity Card",
            "Vietnamese Passport",
            "Vietnam Citizen Identity Card",
            "Zambia National Registration Card",
            "Zimbabwe National Registration Card"
        );
        private $local = array(
            "Local Identity Card (Applicable only within an organization)"
        );
        private $other = array(
            "Other"
        );
        private $allow_local = true;
        public function get_options($selected="") {
            $s = "";
            if ($this->allow_local) {
                foreach ($this->local as $value) {
                    $s .= "<option value='";
                    $s .= "$value";
                    if ($selected == $value) {
                        $s .= "'selected>";
                    } else {
                        $s .= "'>";
                    }
                    $s .= "$value";
                    $s .= "</option>";
                }
            }
            foreach ($this->general as $value) {
                $s .= "<option value='";
                $s .= "$value";
                if ($selected == $value) {
                    $s .= "'selected>";
                } else {
                    $s .= "'>";
                }
                $s .= "$value";
                $s .= "</option>";
            }
            foreach ($this->other as $value) {
                $s .= "<option value='";
                $s .= "$value";
                if ($selected == $value) {
                    $s .= "'selected>";
                } else {
                    $s .= "'>";
                }
                $s .= "$value";
                $s .= "</option>";
            }
            return $s;
        }
        public function validate_idproof($input) {
            if ($this->allow_local) {
                return (
                    in_array($input, $this->general)
                    or (in_array($input, $this->local))
                    or (in_array($input, $this->other))
                );
            }
            else
            {
                return (in_array($input, $general)
                or (in_array($input, $other)));                
            }
        }
    }
?>

<?php
	/**
	 * OpenSSL encryption and decryption class.
	 * 
	 * This connection class has 4 properties:
	 * <ul>
	 * 		<li> $method: The encryption/decryption algorithm used. </li>
	 * 		<li> $passphrase: The passphrase. </li>
	 * 		<li> $options: Bitwise disjunction of flags 
     *               OPENSSL_RAW_DATA and OPENSSL_ZERO_PADDING </li>
	 * 		<li> $iv: Refers to the initialization vector. 
     *               Should not be null. </li>
	 * </ul>
	 * NOTE:
	 * <ul>
	 * 		<li> Please change the passphrase and initialization vector 
     *               as soon as possible. </li>
	 * 		<li> Do not change any of these values 
     *               once the application is deployed </li>
	 * </ul>
     * 
	 * This class can be used in any application.
	 *
	 * @author Burra Abhishek
	 * @license Public Domain
	 * 
	 */
    class SecureData
    {
        private $method = "AES-256-CBC-HMAC-SHA256";
        private $passphrase = "PleasechangethesevaluesASAP";
        private $options = 0;
        private $iv = 'SgvUPKOzdqlw';
        public function encrypt($data) {
            return openssl_encrypt(
                $data,
                $this->method,
                $this->passphrase,
                $this->options,
                $this->iv,
            );
        }
        public function decrypt($data) {
            return openssl_decrypt(
                $data,
                $this->method,
                $this->passphrase,
                $this->options,
                $this->iv,
            );
        }
    }
?>
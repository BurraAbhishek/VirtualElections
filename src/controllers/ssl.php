<?php
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
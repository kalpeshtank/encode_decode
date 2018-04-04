
<?php

define("PASSWORD_PRIVATE_KEY", "abcdefghighijklng!@#$$%^&**12465716786ABCDEFGHIJKLMMOPQRSTU");

class Security {
# Private key
# Encrypt a value using AES-256.

    public static function encrypt($plain, $key) {
        if (strlen($key) < 50) {
            echo "Invalid  key";
            die();
        }
        $key = substr(hash('sha256', $key . PASSWORD_PRIVATE_KEY), 0, 32); # Generate the encryption and hmac key
        $algorithm = MCRYPT_RIJNDAEL_128; # encryption algorithm
        $mode = MCRYPT_MODE_CBC; # encryption mode

        $ivSize = mcrypt_get_iv_size($algorithm, $mode); # Returns the size of the IV belonging to a specific cipher/mode combination
        $iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_URANDOM); # Creates an initialization vector (IV) from a random source
        $ciphertext = $iv . mcrypt_encrypt($algorithm, $key, $plain, $mode, $iv);
# Encrypts plaintext with given parameters
        $hmac = hash_hmac('sha256', $ciphertext, $key); # Generate a keyed hash value using the HMAC method
        return $hmac . $ciphertext;
    }

# Decrypt a value using AES-256.

    public static function decrypt($cipher, $key) {
        if (strlen($key) < 50) {
            var_dump('Invalid key');
//            var_dump('Invalid public key $key, key must be at least 256 bits (32 bytes) long.');
            die();
        }
        if (empty($cipher)) {
            var_dump('The data cannot be empty.');
            die();
        }
        $key = substr(hash('sha256', $key . PASSWORD_PRIVATE_KEY), 0, 32); # Generate the encryption and hmac key.
# Split out hmac for comparison
        $macSize = 64;
        $hmac = substr($cipher, 0, $macSize);
        $cipher = substr($cipher, $macSize);

        $compareHmac = hash_hmac('sha256', $cipher, $key);
        if ($hmac !== $compareHmac) {
            return false;
        }

        $algorithm = MCRYPT_RIJNDAEL_128; # encryption algorithm
        $mode = MCRYPT_MODE_CBC; # encryption mode
        $ivSize = mcrypt_get_iv_size($algorithm, $mode); # Returns the size of the IV belonging to a specific cipher/mode combination

        $iv = substr($cipher, 0, $ivSize);
        $cipher = substr($cipher, $ivSize);
        $plain = mcrypt_decrypt($algorithm, $key, $cipher, $mode, $iv);
        return rtrim($plain, "\0");
    }

}

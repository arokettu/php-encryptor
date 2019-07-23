<?php

namespace SandFox\Encryptor\Algo\V1;

use Exception;
use SandFox\Bencode\Bencode;
use SandFox\Encryptor\Secret\Key;
use SandFox\Encryptor\Secret\Password;

class Encrypt
{
    /**
     * @param string $data
     * @param Key|Password $secret
     * @return string
     * @throws Exception
     */
    public function encrypt(string $data, $secret)
    {
        $container = [
            '_a' => 'sfenc',
            '_v' => 1,
        ];

        if ($secret instanceof Password) {
            $salt = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
            $container['salt'] = $salt;
            $secret->setSalt($salt);
        }

        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

        $container['nonce'] = $nonce;

        $container['payload'] = sodium_crypto_secretbox($data, $nonce, $secret->getKeyV1());

        return Bencode::encode($container);
    }
}

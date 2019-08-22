<?php

namespace SandFox\Encryptor\Algo\V2;

use Exception;
use SandFox\Bencode\Bencode;
use SandFox\Encryptor\Secret\Key;
use SandFox\Encryptor\Secret\Password;

class Encrypt
{
    public const VERSION = 2;

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
            '_v' => self::VERSION,
        ];

        if ($secret instanceof Password) {
            $salt = $this->getSalt();
            $container['salt'] = $salt;
            $container['ops'] = $secret->getOpslimit();
            $container['mem'] = $secret->getMemlimit();
            $secret->setSalt($salt);
        }

        $nonce = $this->getNonce();

        $container['nonce'] = $nonce;

        $container['payload'] = sodium_crypto_secretbox($data, $nonce, $secret->getKeyV2());

        return Bencode::encode($container);
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getSalt()
    {
        return random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getNonce()
    {
        return random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    }
}

<?php

declare(strict_types=1);

namespace Arokettu\Encryptor\Algo\V2;

use Arokettu\Encryptor\Secret\Key;
use Arokettu\Encryptor\Secret\Password;
use SandFox\Bencode\Bencode;

class Encrypt
{
    public const VERSION = 2;

    /**
     * @param resource $input
     * @param resource $output
     * @param Key|Password $secret
     * @throws \Exception
     */
    public function encrypt($input, $output, $secret): void
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

        $container['payload'] = sodium_crypto_secretbox(stream_get_contents($input), $nonce, $secret->getKeyV2());

        Bencode::encodeToStream($container, $output);
    }

    private function getSalt(): string
    {
        return random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
    }

    private function getNonce(): string
    {
        return random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    }
}

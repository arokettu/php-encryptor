<?php

/**
 * @copyright 2019 Anton Smirnov
 * @license MIT https://spdx.org/licenses/MIT.html
 */

declare(strict_types=1);

namespace Arokettu\Encryptor\Algo\V2;

use Arokettu\Bencode\Bencode;
use Arokettu\Encryptor\Secret\Key;
use Arokettu\Encryptor\Secret\Password;
use Random\RandomException;
use SodiumException;

final class Encrypt
{
    public const VERSION = 2;

    /**
     * @param callable(): resource $input
     * @param callable(): resource $output
     * @throws SodiumException|RandomException
     */
    public function encrypt(callable $input, callable $output, Key|Password $secret): void
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

        $key = $secret->getKeyV2();
        $container['payload'] = sodium_crypto_secretbox(stream_get_contents($input()), $nonce, $key);
        sodium_memzero($key);

        Bencode::encodeToStream($container, $output());
    }

    /**
     * @throws RandomException
     */
    private function getSalt(): string
    {
        return random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
    }

    /**
     * @throws RandomException
     */
    private function getNonce(): string
    {
        return random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    }
}

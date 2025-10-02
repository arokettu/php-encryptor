<?php

/**
 * @copyright 2019 Anton Smirnov
 * @license MIT https://spdx.org/licenses/MIT.html
 */

declare(strict_types=1);

namespace Arokettu\Encryptor\Algo\V1;

use Arokettu\Encryptor\Secret\Key;
use Arokettu\Encryptor\Secret\Password;
use RuntimeException;
use SodiumException;

final class Decrypt
{
    /**
     * @throws SodiumException
     */
    public function decryptContainer(array $container, Key|Password $secret): string
    {
        // version and container are already checked, go to decryption

        if ($secret instanceof Password) {
            if (!isset($container['salt'])) {
                throw new RuntimeException('No salt in the container: cannot decrypt with password');
            }

            $secret->setSalt($container['salt']);
            $secret->setOpslimit(4); // hardcode original SODIUM_CRYPTO_PWHASH_OPSLIMIT_SENSITIVE
            $secret->setMemlimit(1073741824); // hardcode original SODIUM_CRYPTO_PWHASH_MEMLIMIT_SENSITIVE
        }

        $nonce   = $container['nonce'] ?? $this->throw('Nonce not found');
        $payload = $container['payload'] ?? $this->throw('Payload not found');

        $key = $secret->getKeyV1();
        $decrypted = sodium_crypto_secretbox_open($payload, $nonce, $key);
        sodium_memzero($key);

        if ($decrypted === false) {
            throw new RuntimeException('Decryption failed');
        }

        return $decrypted;
    }

    private function throw(string $message): string
    {
        throw new RuntimeException($message);
    }
}

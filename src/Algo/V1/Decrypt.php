<?php

namespace SandFox\Encryptor\Algo\V1;

use RuntimeException;
use SandFox\Encryptor\Secret\Password;

class Decrypt
{
    public function decryptContainer(array $container, $secret)
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

        $decrypted = sodium_crypto_secretbox_open($payload, $nonce, $secret->getKeyV1());

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

<?php

namespace SandFox\Encryptor\Algo\V1;

use RuntimeException;
use SandFox\Bencode\Bencode;
use SandFox\Encryptor\Secret\Key;
use SandFox\Encryptor\Secret\Password;

class Decrypt
{
    /**
     * @param string $data
     * @param Key|Password $secret
     * @return bool|string
     */
    public function decrypt(string $data, $secret)
    {
        $container = Bencode::decode($data);

        if ($container['_a'] !== 'sandfoxenc' || $container['_v'] !== 1) {
            throw new RuntimeException('File header is invalid');
        }

        if ($secret instanceof Password) {
            if (!isset($container['salt'])) {
                throw new RuntimeException('No salt in the container: cannot decrypt with password');
            }

            $secret->setSalt($container['salt']);
        }

        $nonce      = $container['nonce']   ?? $this->throw('Nonce not found');
        $payload    = $container['payload'] ?? $this->throw('Payload not found');

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

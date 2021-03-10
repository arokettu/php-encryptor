<?php

declare(strict_types=1);

namespace Arokettu\Encryptor\Algo\V2;

use Arokettu\Encryptor\Algo\V1\Decrypt as DecryptV1;
use Arokettu\Encryptor\Secret\Key;
use Arokettu\Encryptor\Secret\Password;
use SandFox\Bencode\Bencode;

class Decrypt
{
    public const VERSION = 2;

    /**
     * @param string $data
     * @param Key|Password $secret
     * @return bool|string
     */
    public function decrypt(string $data, $secret)
    {
        $container = Bencode::decode($data);

        return $this->decryptContainer($container, $secret);
    }

    public function decryptContainer(array $container, $secret)
    {
        if ($container['_a'] !== 'sfenc') {
            throw new \RuntimeException('File header is invalid');
        }

        if ($container['_v'] !== self::VERSION) {
            switch ($container['_v']) {
                case 1:
                    // Fall back to v1
                    return (new DecryptV1())->decryptContainer($container, $secret);

                default:
                    throw new \RuntimeException('File version is unsupported');
            }
        }

        if ($secret instanceof Password) {
            if (!isset($container['salt'])) {
                throw new \RuntimeException('No salt in the container: cannot decrypt with password');
            }

            $secret->setSalt($container['salt']);
            $secret->setMemlimit($container['mem']);
            $secret->setOpslimit($container['ops']);
        }

        $nonce      = $container['nonce']   ?? $this->throw('Nonce not found');
        $payload    = $container['payload'] ?? $this->throw('Payload not found');

        $decrypted = sodium_crypto_secretbox_open($payload, $nonce, $secret->getKeyV2());

        if ($decrypted === false) {
            throw new \RuntimeException('Decryption failed');
        }

        return $decrypted;
    }

    private function throw(string $message): string
    {
        throw new \RuntimeException($message);
    }
}

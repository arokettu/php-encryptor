<?php

declare(strict_types=1);

namespace Arokettu\Encryptor\Secret;

use RuntimeException;

class Key
{
    private $key;

    public function __construct(string $key)
    {
        $key = @hex2bin($key);

        if ($key === false) {
            throw new RuntimeException('Key is not a valid hexadecimal value');
        }

        if (\strlen($key) !== SODIUM_CRYPTO_SECRETBOX_KEYBYTES) {
            throw new RuntimeException('Key must encode ' . SODIUM_CRYPTO_SECRETBOX_KEYBYTES . ' bytes of data');
        }

        $this->key = $key;
    }

    public function __destruct()
    {
        sodium_memzero($this->key);
    }

    public function getKeyV2(): string
    {
        return $this->key;
    }

    public function getKeyV1(): string
    {
        return $this->key;
    }
}

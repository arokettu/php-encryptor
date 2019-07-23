<?php

namespace SandFox\Encryptor\Secret;

use LogicException;

class Password
{
    private $password;
    private $salt;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function setSalt(string $salt)
    {
        $this->salt = $salt;
    }

    public function getKeyV1(): string
    {
        if ($this->salt === null) {
            throw new LogicException('Cannot produce key without salt');
        }

        if (strlen($this->salt) !== SODIUM_CRYPTO_PWHASH_SALTBYTES) {
            throw new LogicException('Incorrect salt length');
        }

        return sodium_crypto_pwhash(
            SODIUM_CRYPTO_SECRETBOX_KEYBYTES,
            $this->password,
            $this->salt,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_SENSITIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_SENSITIVE,
            SODIUM_CRYPTO_PWHASH_ALG_ARGON2I13
        );
    }
}

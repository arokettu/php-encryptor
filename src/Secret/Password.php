<?php

namespace SandFox\Encryptor\Secret;

use LogicException;
use UnexpectedValueException;

class Password
{
    public const STRENGTH_MINIMUM   = 1;
    public const STRENGTH_MODERATE  = 2;
    public const STRENGTH_MAXIMUM   = 3;

    public const STRENGTH_DEFAULT   = self::STRENGTH_MODERATE;

    protected const DEFAULT_ALG = SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13;

    private $password;
    private $salt;
    private $opslimit;
    private $memlimit;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function setSalt(string $salt)
    {
        $this->salt = $salt;
    }

    public function setStrength(int $strength)
    {
        switch ($strength) {
            case self::STRENGTH_MINIMUM:
                $this->setOpslimit(SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE);
                $this->setMemlimit(SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);
                break;

            case self::STRENGTH_MODERATE:
                $this->setOpslimit(SODIUM_CRYPTO_PWHASH_OPSLIMIT_MODERATE);
                $this->setMemlimit(SODIUM_CRYPTO_PWHASH_MEMLIMIT_MODERATE);
                break;

            case self::STRENGTH_MAXIMUM:
                $this->setOpslimit(SODIUM_CRYPTO_PWHASH_OPSLIMIT_SENSITIVE);
                $this->setMemlimit(SODIUM_CRYPTO_PWHASH_MEMLIMIT_SENSITIVE);
                break;

            default:
                throw new UnexpectedValueException(sprintf('Unknown strength level: %d', $strength));
        }
    }

    public function setOpslimit(int $opslimit): void
    {
        $this->opslimit = $opslimit;
    }

    public function setMemlimit(int $memlimit): void
    {
        $this->memlimit = $memlimit;
    }

    public function getOpslimit(): int
    {
        if ($this->opslimit === null) {
            throw new LogicException('Ops Limit was not set');
        }

        return $this->opslimit;
    }

    public function getMemlimit(): int
    {
        if ($this->memlimit === null) {
            throw new LogicException('Mem Limit was not set');
        }

        return $this->memlimit;
    }

    public function getKeyV2(): string
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
            $this->getOpslimit(),
            $this->getMemlimit(),
            self::DEFAULT_ALG
        );
    }
}

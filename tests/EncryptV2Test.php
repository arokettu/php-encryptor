<?php

/**
 * @copyright 2019 Anton Smirnov
 * @license MIT https://spdx.org/licenses/MIT.html
 */

declare(strict_types=1);

namespace Arokettu\Encryptor\Tests;

use Arokettu\Encryptor\Algo\V2\Decrypt;
use Arokettu\Encryptor\Algo\V2\Encrypt;
use Arokettu\Encryptor\Secret\Key;
use Arokettu\Encryptor\Secret\Password;
use PHPUnit\Framework\TestCase;

final class EncryptV2Test extends TestCase
{
    use TestData;

    public function testEncryptWithPassword(): void
    {
        $decrypted = $this->getDecrypted();

        $password = $this->getPassword();
        $secret = new Password($password);

        $encryptor = new Encrypt();
        $decryptor = new Decrypt();

        foreach (range(1, 3) as $strength) {
            $secret->setStrength($strength);

            $encryptedStream = $this->getTempStream();

            $encryptor->encrypt($this->getTempStream($decrypted), $encryptedStream, $secret);
            $encrypted = $this->readTempStream($encryptedStream());

            $decrypted2Stream = $this->getTempStream();
            $decryptor->decrypt($this->getTempStream($encrypted), $decrypted2Stream, $secret);
            $decrypted2 = $this->readTempStream($decrypted2Stream());

            $this->assertEquals($decrypted, $decrypted2);
        }
    }

    public function testEncryptWithKey(): void
    {
        $decrypted = $this->getDecrypted();

        $encryptor = new Encrypt();
        $decryptor = new Decrypt();

        $key = $this->getKey_V2_S2();
        $secret = new Key($key);

        $encryptedStream = $this->getTempStream();
        $encryptor->encrypt($this->getTempStream($decrypted), $encryptedStream, $secret);
        $encrypted = $this->readTempStream($encryptedStream());

        $decrypted2Stream = $this->getTempStream();
        $decryptor->decrypt($this->getTempStream($encrypted), $decrypted2Stream, $secret);
        $decrypted2 = $this->readTempStream($decrypted2Stream());

        $this->assertEquals($decrypted, $decrypted2);
    }
}

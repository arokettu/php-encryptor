<?php

/**
 * @copyright 2019 Anton Smirnov
 * @license MIT https://spdx.org/licenses/MIT.html
 */

declare(strict_types=1);

namespace Arokettu\Encryptor\Tests;

use Arokettu\Encryptor\Algo\V2\Decrypt;
use Arokettu\Encryptor\Secret\Key;
use Arokettu\Encryptor\Secret\Password;
use PHPUnit\Framework\TestCase;

final class DecryptV1Test extends TestCase
{
    use TestData;

    public function testDecryptPasswordV1(): void
    {
        $decrypt = new Decrypt();

        $password = $this->getPassword();
        $secret = new Password($password);

        $decryptedStream = $this->getTempStream();
        $decrypt->decrypt($this->getTempStream($this->getEncrypted_V1()), $decryptedStream, $secret);
        $decrypted = $this->readTempStream($decryptedStream());

        $this->assertEquals($this->getDecrypted(), $decrypted);
    }

    public function testDecryptKeyV1(): void
    {
        $decrypt = new Decrypt();

        $key = $this->getKey_V1();
        $secret = new Key($key);

        $decryptedStream = $this->getTempStream();
        $decrypt->decrypt($this->getTempStream($this->getEncrypted_V1()), $decryptedStream, $secret);
        $decrypted = $this->readTempStream($decryptedStream());

        $this->assertEquals($this->getDecrypted(), $decrypted);
    }
}

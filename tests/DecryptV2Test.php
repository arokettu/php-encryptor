<?php

declare(strict_types=1);

namespace Arokettu\Encryptor\Tests;

use Arokettu\Encryptor\Algo\V2\Decrypt;
use Arokettu\Encryptor\Secret\Key;
use Arokettu\Encryptor\Secret\Password;
use PHPUnit\Framework\TestCase;

final class DecryptV2Test extends TestCase
{
    use TestData;

    public function testDecryptPasswordV2(): void
    {
        $decrypt = new Decrypt();
        $password = $this->getPassword();
        $secret = new Password($password);

        foreach (
            [
                $this->getEncrypted_V2_S1(),
                $this->getEncrypted_V2_S2(),
                $this->getEncrypted_V2_S3(),
            ] as $encrypted
        ) {
            $decryptedStream = $this->getTempStream();
            $decrypt->decrypt($this->getTempStream($encrypted), $decryptedStream, $secret);
            $decrypted = $this->readTempStream($decryptedStream());

            $this->assertEquals($this->getDecrypted(), $decrypted);
        }
    }

    public function testDecryptKeyV2(): void
    {
        $decrypt = new Decrypt();

        foreach (
            [
                [$this->getEncrypted_V2_S1(), $this->getKey_V2_S1()],
                [$this->getEncrypted_V2_S2(), $this->getKey_V2_S2()],
                [$this->getEncrypted_V2_S3(), $this->getKey_V2_S3()],
            ] as [$encrypted, $key]
        ) {
            $secret = new Key($key);

            $decryptedStream = $this->getTempStream();
            $decrypt->decrypt($this->getTempStream($encrypted), $decryptedStream, $secret);
            $decrypted = $this->readTempStream($decryptedStream());

            $this->assertEquals($this->getDecrypted(), $decrypted);
        }
    }
}

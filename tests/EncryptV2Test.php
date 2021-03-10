<?php

use PHPUnit\Framework\TestCase;
use SandFox\Encryptor\Algo\V2\Decrypt;
use SandFox\Encryptor\Algo\V2\Encrypt;
use SandFox\Encryptor\Secret\Key;
use SandFox\Encryptor\Secret\Password;

class EncryptV2Test extends TestCase
{
    use TestData;

    public function testEncryptWithPassword()
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
            $encrypted = $this->readTempStream($encryptedStream);

            $decrypted2 = $decryptor->decrypt($encrypted, $secret);
            $this->assertEquals($decrypted, $decrypted2);
        }
    }

    public function testEncryptWithKey()
    {
        $decrypted = $this->getDecrypted();

        $encryptor = new Encrypt();
        $decryptor = new Decrypt();

        $key = $this->getKey_V2_S2();
        $secret = new Key($key);

        $encryptedStream = $this->getTempStream();
        $encryptor->encrypt($this->getTempStream($decrypted), $encryptedStream, $secret);
        $encrypted = $this->readTempStream($encryptedStream);
        $decrypted2 = $decryptor->decrypt($encrypted, $secret);

        $this->assertEquals($decrypted, $decrypted2);
    }
}

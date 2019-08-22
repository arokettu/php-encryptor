<?php

use PHPUnit\Framework\TestCase;
use SandFox\Encryptor\Algo\V2\Decrypt;
use SandFox\Encryptor\Secret\Key;
use SandFox\Encryptor\Secret\Password;

class DecryptV1Test extends TestCase
{
    use TestData;

    public function testDecryptPasswordV1()
    {
        $decrypt = new Decrypt();
        $password = $this->getPassword();
        $secret = new Password($password);
        $this->assertEquals(
            $this->getDecrypted(),
            $decrypt->decrypt($this->getEncrypted_V1(), $secret)
        );
    }

    public function testDecryptKeyV1()
    {
        $decrypt = new Decrypt();
        $key = $this->getKey_V1();
        $secret = new Key($key);
        $this->assertEquals(
            $this->getDecrypted(),
            $decrypt->decrypt($this->getEncrypted_V1(), $secret)
        );
    }
}

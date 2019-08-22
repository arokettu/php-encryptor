<?php

use PHPUnit\Framework\TestCase;
use SandFox\Encryptor\Algo\V2\Decrypt;
use SandFox\Encryptor\Secret\Key;
use SandFox\Encryptor\Secret\Password;

class DecryptV2Test extends TestCase
{
    use TestData;

    public function testDecryptPasswordV2()
    {
        $decrypt = new Decrypt();
        $password = $this->getPassword();
        $secret = new Password($password);

        foreach ([
            $this->getEncrypted_V2_S1(),
            $this->getEncrypted_V2_S2(),
            $this->getEncrypted_V2_S3(),
        ] as $encrypted) {
            $this->assertEquals(
                $this->getDecrypted(),
                $decrypt->decrypt($encrypted, $secret)
            );
        }
    }

    public function testDecryptKeyV2()
    {
        $decrypt = new Decrypt();

        foreach ([
            [$this->getEncrypted_V2_S1(), $this->getKey_V2_S1()],
            [$this->getEncrypted_V2_S2(), $this->getKey_V2_S2()],
            [$this->getEncrypted_V2_S3(), $this->getKey_V2_S3()],
        ] as [$encrypted, $key]) {
            $secret = new Key($key);
            $this->assertEquals(
                $this->getDecrypted(),
                $decrypt->decrypt($encrypted, $secret)
            );
        }
    }
}

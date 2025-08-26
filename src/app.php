<?php

declare(strict_types=1);

use Arokettu\Encryptor\Commands\Decrypt;
use Arokettu\Encryptor\Commands\Encrypt;
use Composer\InstalledVersions;
use Symfony\Component\Console\Application;

$app = new Application(
    'arokettu/encryptor',
    Phar::running() !== '' ? '@version@' : InstalledVersions::getPrettyVersion('arokettu/encryptor'),
);

$app->add(new Decrypt());
$app->add(new Encrypt());

return $app;

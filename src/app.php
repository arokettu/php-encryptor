<?php

use Composer\InstalledVersions;
use SandFox\Encryptor\Commands\Decrypt;
use SandFox\Encryptor\Commands\Encrypt;
use Symfony\Component\Console\Application;

$version = class_exists(InstalledVersions::class) ? InstalledVersions::getPrettyVersion('arokettu/encryptor') : null;

$app = new Application('Encryptor', $version);

$app->add(new Decrypt());
$app->add(new Encrypt());

$app->run();

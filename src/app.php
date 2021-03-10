<?php

declare(strict_types=1);

use Arokettu\Encryptor\Commands\Decrypt;
use Arokettu\Encryptor\Commands\Encrypt;
use Composer\InstalledVersions;
use Symfony\Component\Console\Application;

$version = class_exists(InstalledVersions::class) ? InstalledVersions::getPrettyVersion('arokettu/encryptor') : null;

$app = new Application('Encryptor', $version);

$app->add(new Decrypt());
$app->add(new Encrypt());

$app->run();

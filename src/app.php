<?php

declare(strict_types=1);

use Arokettu\Encryptor\Commands\Decrypt;
use Arokettu\Encryptor\Commands\Encrypt;
use Composer\InstalledVersions;
use Symfony\Component\Console\Application;

if (Phar::running() !== '') {
    $version = ['@version@'];
} elseif (class_exists(InstalledVersions::class)) {
    $version = [InstalledVersions::getPrettyVersion('arokettu/encryptor')];
} else {
    $version = [];
}

$app = new Application('Encryptor', ...$version); // do not pass second parameter at all if the version was not detected

$app->add(new Decrypt());
$app->add(new Encrypt());

$app->run();

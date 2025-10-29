<?php

/**
 * @copyright 2019 Anton Smirnov
 * @license MIT https://spdx.org/licenses/MIT.html
 */

declare(strict_types=1);

use Arokettu\Encryptor\Commands\Decrypt;
use Arokettu\Encryptor\Commands\Encrypt;
use Composer\InstalledVersions;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;

$app = new Application(
    'arokettu/encryptor',
    Phar::running() !== '' ? '@version@' : InstalledVersions::getPrettyVersion('arokettu/encryptor'),
);

$app->setCommandLoader(new FactoryCommandLoader([
    Decrypt::NAME => static fn () => new Decrypt(),
    Encrypt::NAME => static fn () => new Encrypt(),
]));

return $app;

<?php

use SandFox\Encryptor\Commands\Decrypt;
use SandFox\Encryptor\Commands\Encrypt;
use Symfony\Component\Console\Application;

$app = new Application('Encryptor', require 'version.php');

$app->add(new Decrypt());
$app->add(new Encrypt());

$app->run();

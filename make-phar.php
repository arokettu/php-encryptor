<?php

use Secondtruth\Compiler\Compiler;

require 'vendor/autoload.php';

if (!is_dir(__DIR__ . '/build')) {
    mkdir(__DIR__ . '/build');
}

$phar = new Compiler(__DIR__);

$phar->addIndexFile('bin/encryptor');

$phar->addDirectory('src');
$phar->addDirectory('vendor', [
    // ignore non php files
    '!*.php',
    // various tests
    'Tester/*',
    'Tests/*',
    'Test/*',
    // compiler
    'secondtruth/*'
]);

$phar->compile(__DIR__ . '/build/encryptor.phar');

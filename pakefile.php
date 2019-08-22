<?php

use Secondtruth\Compiler\Compiler;

pake_desc('Build phar');
pake_task('build');

function run_build()
{
if (!is_dir(__DIR__ . '/build')) {
    mkdir(__DIR__ . '/build');
}

$version = trim(`git describe --tags`);

$versionFile = __DIR__ . '/src/version.php';

$oldVersion = file_get_contents($versionFile);
file_put_contents($versionFile, "<?php return '{$version}';" . PHP_EOL);

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

file_put_contents($versionFile, $oldVersion);
}

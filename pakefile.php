<?php

// @codingStandardsIgnoreFile

use Secondtruth\Compiler\Compiler;

pake_desc('Build phar');
pake_task('build');
/**
 * @throws pakeException
 */
function run_build()
{
    pake_echo('Creating build directory');

    $buildDir = __DIR__ . '/build/copy';
    $all = pakeFinder::type('any');

    // recreate empty build directory
    pake_remove($all, $buildDir);
    pake_mkdirs(__DIR__ . '/build/copy');

    pake_mirror($all, __DIR__ . '/bin', $buildDir . '/bin');
    pake_mirror($all, __DIR__ . '/src', $buildDir . '/src');
    pake_copy(__DIR__ . '/composer.json', $buildDir . '/composer.json');
    pake_copy(__DIR__ . '/composer.lock', $buildDir . '/composer.lock');

    pake_echo('Writing version');

    $version = trim(`git describe --tags`);
    $versionFile = $buildDir . '/src/version.php';
    file_put_contents($versionFile, "<?php return '{$version}';" . PHP_EOL);

    pake_echo('Installing dependencies');

    pake_sh("cd {$buildDir} && composer install --no-dev --optimize-autoloader");

    pake_echo('Compiling phar');

    $phar = new Compiler($buildDir);

    $phar->addIndexFile('bin/encryptor');

    $phar->addDirectory('src');
    $phar->addDirectory('vendor', [
        // ignore non php files
        '!*.php',
        // test files
        '*/Tests/*',
        '*/Tester/*',
        '*/Test/*',
        '*/tests/*',
        '*/test/*',
    ]);

    $phar->compile(__DIR__ . '/build/encryptor.phar');

    pake_echo('Done');
}

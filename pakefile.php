<?php

// @codingStandardsIgnoreFile

use Github\Client;
use Github\Exception\RuntimeException as GithubRuntimeException;
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
    $version = preg_replace('/-/', '+git-', $version, 1);
    pake_sh("cd {$buildDir} && composer config version {$version}");

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

pake_desc('Upload release to GitHub');
pake_task('upload');
/**
 *
 * @throws pakeException
 */
function run_upload()
{
    if (! file_exists(__DIR__ . '/build/encryptor.phar')) {
        throw new RuntimeException('No built project');
    }

    $version = trim(`git describe --tags`);

    $token = getenv('GITHUB_TOKEN');

    if (empty($token)) {
        throw new RuntimeException('Token is not set');
    }

    $github = new Client();
    $github->authenticate($token, '', Client::AUTH_ACCESS_TOKEN);

    try {
        $release = $github->api('repo')->releases()->tag('arokettu', 'php-encryptor', $version);
        $assets = $github->api('repo')->releases()->assets()->all('arokettu', 'php-encryptor', $release['id']);
        foreach ($assets as $asset) {
            if ($asset['name'] === 'encryptor.phar') {
                throw new RuntimeException('Asset already exists');
            }
        }
    } catch (GithubRuntimeException $e) {
        $tags = $github->api('repo')->tags('arokettu', 'php-encryptor');

        $tagFound = false;
        foreach ($tags as $tag) {
            if ($tag['name'] === $version) {
                $tagFound = true;
            }
        }

        if (! $tagFound) {
            throw new RuntimeException('Tag does not exist');
        }

        $release = $github->api('repo')->releases()->create('arokettu', 'php-encryptor', array('tag_name' => $version));
    }

    $github->api('repo')->releases()->assets()->create(
        'arokettu',
        'php-encryptor',
        $release['id'],
        'encryptor.phar',
        'application/octet-stream',
        pake_read_file(__DIR__ . '/build/encryptor.phar')
    );
}

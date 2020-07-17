<?php

use Composer\InstalledVersions;

if (class_exists(InstalledVersions::class)) {
    return InstalledVersions::getPrettyVersion('arokettu/encryptor');
} else {
    return 'dev-master';
}

# File Encryptor

[![Packagist](https://img.shields.io/packagist/v/sandfoxme/encryptor.svg)](https://packagist.org/packages/sandfoxme/encryptor)
[![Packagist](https://img.shields.io/github/license/sandfoxme/php-encryptor.svg)](https://opensource.org/licenses/MIT)
[![Travis](https://img.shields.io/travis/sandfoxme/php-encryptor.svg)](https://travis-ci.org/sandfoxme/php-encryptor)

A small and simple tool to encrypt small files with with [libsodium].

## Installation

Install for local user with composer:

```sh
composer global require sandfoxme/encryptor
```

Install globally by downloading prebuilt phar:

```sh
sudo wget https://github.com/sandfoxme/php-encryptor/releases/latest/download/encryptor.phar -O /usr/local/bin/encryptor
sudo chmod +x /usr/local/bin/encryptor
```

## Simple usage

Encrypt file:

```sh
encryptor encrypt filename.txt
```

Decrypt file:

```sh
encryptor decrypt filename.txt.encrypted
```

You will be interactively asked for the password

## License

The library is available as open source under the terms of the [MIT License].

[libsodium]: https://libsodium.gitbook.io/
[MIT License]:  https://opensource.org/licenses/MIT

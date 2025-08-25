Encryptor
#########

|Packagist| |GitLab| |GitHub| |Codeberg| |Gitea|

A small and simple tool to encrypt small files with with libsodium_.

Installation
============

Install for local user with composer::

   composer global require arokettu/encryptor

Install for all users by downloading prebuilt phar::

   sudo wget https://github.com/arokettu/php-encryptor/releases/latest/download/encryptor.phar -O /usr/local/bin/encryptor
   sudo chmod +x /usr/local/bin/encryptor

Documentation
=============

.. toctree::
   :maxdepth: 2

   cli
   file_format

License
=======

The library is available as open source under the terms of the `MIT License`_.

.. _libsodium:          https://libsodium.gitbook.io/
.. _MIT License:        https://opensource.org/licenses/MIT

.. |Packagist|  image:: https://img.shields.io/packagist/v/arokettu/encryptor.svg?style=flat-square
   :target:     https://packagist.org/packages/arokettu/encryptor
.. |GitHub|     image:: https://img.shields.io/badge/get%20on-GitHub-informational.svg?style=flat-square&logo=github
   :target:     https://github.com/arokettu/php-encryptor
.. |GitLab|     image:: https://img.shields.io/badge/get%20on-GitLab-informational.svg?style=flat-square&logo=gitlab
   :target:     https://gitlab.com/sandfox/php-encryptor
.. |Codeberg|   image:: https://img.shields.io/badge/get%20on-Codeberg-informational.svg?style=flat-square&logo=codeberg
   :target:     https://codeberg.org/sandfox/php-encryptor
.. |Gitea|      image:: https://img.shields.io/badge/get%20on-Gitea-informational.svg?style=flat-square&logo=gitea
   :target:     https://sandfox.org/sandfox/php-encryptor

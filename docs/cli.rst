Command Line
############

::

   encryptor encrypt|decrypt [-o|--output=OUTPUT_FILE] [--stdout] [-k|--key=KEY]
             [-p|--password=PASSWORD] [-s|--strength=STRENGTH] [<INPUT_FILE>]

-o, --output=OUTPUT_FILE    Output file.
--stdout                    Force output to stdout.
-k, --key=KEY               Encrypt/decrypt data with a binary key.
                            The key must be 32 bytes long encoded in hexadecimal.
-p, --password=PASSWORD     Encrypt/decrypt data with password.
-s, --strength=STRENGTH     Encryption only: Key derivation strength for password encryption. (1-3, default 2)

If no input file is specified, the tool will read from stdin.

If neither ``--output`` nor ``--stdout`` are specified:

* If data is read from stdin, output will be stdout
* On encryption: INPUT_FILE.encrypted
* On decryption: if input file is INPUT_FILE.enctypted, then INPUT_FILE, otherwise INPUT_FILE.decrypted

If neither key nor password are given in parameters, a password will be requested interactively

Key derivation strength sets opslimit/memlimit for Argon2id key derivation. Default level is MODERATE

.. list-table::
   :header-rows: 1

   * - Strength
     - Limit constants
   * - 1
     - INTERACTIVE
   * - 2
     - MODERATE
   * - 3
     - SENSITIVE

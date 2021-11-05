File Format
###########

Encrypted file is a bencoded_ dictionary with the following keys:

.. _bencoded: https://en.wikipedia.org/wiki/Bencode

.. list-table::
   :header-rows: 1

   * - key
     - value
     - description
   * - _a
     - "sfenc"
     - Header
   * - _v
     - 1 or 2
     - Container version
   * - salt
     - 16 random bytes
     - Password salt. Unset if encrypted with a key
   * - ops
     - integer
     - Argon2id opslimit. Unset if encrypted with a key (v2 only)
   * - mem
     - integer
     - Argon2id memlimit. Unset if encrypted with a key (v2 only)
   * - nonce
     - 24 random bytes
     - Xsalsa20 nonce
   * - payload
     - long binary string
     - Xsalsa20 + Poly1305 encrypted payload

The file is guaranteed to start with ``d2:_a5:sfenc2:_v``

V1 and V2 differences:

* V2 uses Argon2id, V1 uses Argon2i
* V2 uses ops and mem form the container, V1 always uses SENSITIVE (ops=4, mem=1_073_741_824, hardcoded since 1.1)
* V1 and V2 are equal when encrypting with a key except for the version header

V1 was used during early development.
If you somehow used my dev version, you can still decode your files
but it may break if libsodium changes the constants.

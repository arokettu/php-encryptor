<?php

declare(strict_types=1);

namespace Arokettu\Encryptor\Commands;

use Arokettu\Encryptor\Algo\V2;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Decrypt extends Base
{
    protected function configure(): void
    {
        $this->setName('decrypt');
        $this->setDescription('Decrypts a file');

        $this->configureOptions();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputFile  = fn () => $this->getInputFile($input);
        $outputFile = fn () => $this->getOutputFile($input);
        $secret     = $this->getSecret($input, $output);

        $dec = new V2\Decrypt();

        $dec->decrypt($inputFile, $outputFile, $secret);

        return 0;
    }

    protected function makeOutputFileName(string $inputFileName): string
    {
        $inputFileNameInsensitive = strtolower($inputFileName);

        if (str_ends_with($inputFileNameInsensitive, self::EXT) && $inputFileNameInsensitive !== self::EXT) {
            return substr($inputFileName, 0, -\strlen(self::EXT));
        }

        return $inputFileName . '.decrypted';
    }
}

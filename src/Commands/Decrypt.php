<?php

namespace SandFox\Encryptor\Commands;

use SandFox\Encryptor\Algo\V2;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Decrypt extends Base
{
    protected function configure()
    {
        $this->setName('decrypt');
        $this->setDescription('Decrypts a file');

        $this->configureOptions();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputFilename  = $this->getInputFileName($input);
        $outputFilename = $this->getOutputFileName($input);
        $secret         = $this->getSecret($input, $output);

        $data = file_get_contents($inputFilename);

        $dec = new V2\Decrypt();

        file_put_contents($outputFilename, $dec->decrypt($data, $secret));

        return 0;
    }

    protected function makeOutputFileName(string $inputFileName): string
    {
        $inputFileNameInsensitive = strtolower($inputFileName);

        if (str_ends_with($inputFileNameInsensitive, self::EXT) && $inputFileNameInsensitive !== self::EXT) {
            return substr($inputFileName, 0, -strlen(self::EXT));
        }

        return $inputFileName . '.decrypted';
    }
}

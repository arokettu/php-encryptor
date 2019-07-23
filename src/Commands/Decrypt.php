<?php

namespace SandFox\Encryptor\Commands;

use SandFox\Encryptor\Algo\V1;
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

        $dec = new V1\Decrypt();

        file_put_contents($outputFilename, $dec->decrypt($data, $secret));
    }

    protected function makeOutputFileName(string $inputFileName): string
    {
        if (str_ends_with_ci($inputFileName, self::EXT) && $inputFileName !== self::EXT) {
            return substr($inputFileName, 0, -strlen(self::EXT));
        }

        return $inputFileName . '.decrypted';
    }
}

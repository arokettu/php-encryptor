<?php

namespace SandFox\Encryptor\Commands;

use SandFox\Encryptor\Algo\V1;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Encrypt extends Base
{
    protected function configure()
    {
        $this->setName('encrypt');
        $this->setDescription('Encrypts a file');

        $this->configureOptions();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputFilename  = $this->getInputFileName($input);
        $outputFilename = $this->getOutputFileName($input);
        $secret         = $this->getSecret($input, $output);

        $data = file_get_contents($inputFilename);

        $enc = new V1\Encrypt();

        file_put_contents($outputFilename, $enc->encrypt($data, $secret));
    }

    protected function makeOutputFileName(string $inputFileName): string
    {
        return $inputFileName . self::EXT;
    }
}

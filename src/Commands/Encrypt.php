<?php

declare(strict_types=1);

namespace Arokettu\Encryptor\Commands;

use Arokettu\Encryptor\Algo\V2;
use Arokettu\Encryptor\Secret\Key;
use Arokettu\Encryptor\Secret\Password;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Encrypt extends Base
{
    protected function configure(): void
    {
        $this->setName('encrypt');
        $this->setDescription('Encrypts a file');

        $this->configureOptions();

        $this->addOption(
            'strength',
            's',
            InputOption::VALUE_REQUIRED,
            'Password derivation strength (1-3)',
            Password::STRENGTH_DEFAULT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputFilename  = $this->getInputFileName($input);
        $outputFilename = $this->getOutputFileName($input);
        $secret         = $this->getSecret($input, $output);

        $inputFile  = fopen($inputFilename, 'r');
        $outputFile = fopen($outputFilename, 'w');

        if ($inputFile === false) {
            throw new \RuntimeException('Error reading the input file');
        }
        if ($outputFile === false) {
            throw new \RuntimeException('Error writing to the output file');
        }

        $enc = new V2\Encrypt();

        $enc->encrypt($inputFile, $outputFile, $secret);

        return 0;
    }

    protected function makeOutputFileName(string $inputFileName): string
    {
        return $inputFileName . self::EXT;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return Key|Password
     */
    protected function getSecret(InputInterface $input, OutputInterface $output)
    {
        $secret = parent::getSecret($input, $output);
        if ($secret instanceof Password) {
            $secret->setStrength($input->getOption('strength'));
        }
        return $secret;
    }
}

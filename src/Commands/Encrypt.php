<?php

namespace SandFox\Encryptor\Commands;

use SandFox\Encryptor\Algo\V2;
use SandFox\Encryptor\Secret\Password;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Encrypt extends Base
{
    protected function configure()
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputFilename  = $this->getInputFileName($input);
        $outputFilename = $this->getOutputFileName($input);
        $secret         = $this->getSecret($input, $output);

        $data = file_get_contents($inputFilename);

        $enc = new V2\Encrypt();

        file_put_contents($outputFilename, $enc->encrypt($data, $secret));
    }

    protected function makeOutputFileName(string $inputFileName): string
    {
        return $inputFileName . self::EXT;
    }

    protected function getSecret(InputInterface $input, OutputInterface $output)
    {
        $secret = parent::getSecret($input, $output);
        if ($secret instanceof Password) {
            $secret->setStrength($input->getOption('strength'));
        }
        return $secret;
    }
}

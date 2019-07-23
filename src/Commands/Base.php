<?php

namespace SandFox\Encryptor\Commands;

use RuntimeException;
use SandFox\Encryptor\Secret\Key;
use SandFox\Encryptor\Secret\Password;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

abstract class Base extends Command
{
    protected const EXT = '.encrypted';

    protected $stdin = false;

    protected function configureOptions()
    {
        $this->addArgument('input', InputArgument::OPTIONAL, 'Input file (stdin if omitted)');

        $this->addOption('output',      'o',    InputOption::VALUE_REQUIRED,
            'Output file (derived from input file name if omitted, stdout if stdin)');
        $this->addOption('stdout',      null,   InputOption::VALUE_NONE,
            'Force output into stdout');
        $this->addOption('key',         'k',    InputOption::VALUE_REQUIRED,
            sprintf('Encryption key, hex-encoded %d byte length key. More secure option than a password', SODIUM_CRYPTO_SECRETBOX_KEYBYTES));
        $this->addOption('password',    'p',    InputOption::VALUE_REQUIRED,
            'Encryption password. If neither key nor password are provided, the program will ask for a password');
    }

    protected function getInputFileName(InputInterface $input): string
    {
        $filename = $input->getArgument('input');

        if ($filename === null) {
            $this->stdin = true;
            return 'php://stdin';
        }

        $filename = realpath($filename);

        if (!$filename || !is_file($filename) || !is_readable($filename)) {
            throw new RuntimeException('Input file is not readable');
        }

        return $filename;
    }

    abstract protected function makeOutputFileName(string $inputFileName): string;

    protected function getOutputFileName(InputInterface $input): string
    {
        $stdout   = $input->getOption('stdout');
        $filename = $input->getOption('output');

        if ($stdout && $filename) {
            throw new RuntimeException('Both --output and --stdout are specified');
        }

        if ($stdout || $this->stdin && $filename === null) {
            return 'php://stdout';
        }

        if ($filename === null) {
            $filename = $this->makeOutputFileName($this->getInputFileName($input));
        }

        $basedir = dirname($filename);

        if (is_file($filename) && is_writable($filename) || is_dir($basedir) && is_writable($basedir)
        ) {
            return $filename;
        }

        throw new RuntimeException('Output file is not writable');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return Key|Password
     */
    protected function getSecret(InputInterface $input, OutputInterface $output)
    {
        $key        = $input->getOption('key');
        $password   = $input->getOption('password');

        if ($key !== null && $password !== null) {
            throw new RuntimeException('Both --key and --password are specified');
        }

        if ($key !== null) {
            return new Key($key);
        }

        if ($password === null) {
            /** @var QuestionHelper $helper */
            $helper = $this->getHelper('question');

            $question = new Question('Please provide the password: ');
            $question->setHidden(true);
            $question->setNormalizer('trim');
            $question->setValidator(function ($pwd) {
                if (strlen($pwd > 0)) {
                    return $pwd;
                }

                throw new RuntimeException('Empty password!'); // message is discarded here
            });
            $question->setMaxAttempts(3);

            $password = $helper->ask(
                $input,
                $output instanceof ConsoleOutputInterface ? $output->getErrorOutput() : $output,
                $question
            );
        }

        return new Password($password);
    }
}

<?php

namespace PasswordGen\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Compare a raw password to a hash to see if they match.
 *
 * @author  Kyle Tucker <kyleatucker@gmail.com>
 */
class CheckCommand extends Command
{
    /** @const Number of iterations, log-2 */
    const HASH_ITERATIONS = 8;

    /** @const Whether to use portable hashes */
    const HASH_PORTABLE = true;

    /** @var \PasswordHash */
    protected $phpass;

    /**
     * HashCommand constructor.
     *
     * @param  string|null  $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->phpass = new \PasswordHash(self::HASH_ITERATIONS, self::HASH_PORTABLE);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Check a password against a hash.');

        $this->addArgument('raw', InputArgument::REQUIRED, 'The raw password')
            ->addArgument('hash', InputArgument::REQUIRED, 'The password hash to compare');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $raw = $input->getArgument('raw');
        $hash = $input->getArgument('hash');

        if ($this->phpass->CheckPassword($raw, $hash)) {
            $output->writeln('Match? <info>YEP</info>');
        } else {
            $output->writeln('Match? <error> NOPE </error>');
        }
    }
}

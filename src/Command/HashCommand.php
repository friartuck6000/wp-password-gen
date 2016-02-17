<?php

namespace PasswordGen\Command;

use Phpass\PasswordHash;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Produce a hash of a raw password.
 *
 * @author  Kyle Tucker <kyleatucker@gmail.com>
 */
class HashCommand extends Command
{
    /** @const Number of iterations, log-2 */
    const HASH_ITERATIONS = 8;

    /** @const Whether to use portable hashes */
    const HASH_PORTABLE = true;

    /** @var PasswordHash */
    protected $phpass;

    /**
     * HashCommand constructor.
     *
     * @param  string|null  $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->phpass = new PasswordHash(self::HASH_ITERATIONS, self::HASH_PORTABLE);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Produce a hash of the given raw password');

        $this->addArgument('raw', InputArgument::REQUIRED, 'The raw password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $raw = $input->getArgument('raw');
        $hash = $this->phpass->HashPassword($raw);

        $output->writeln('<info>Generated hash:</info> '. $hash);
    }
}

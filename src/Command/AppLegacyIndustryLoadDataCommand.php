<?php

namespace App\Command;

use App\LegacyIndustry\Loader\Clearer;
use App\LegacyIndustry\Loader\Loader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppLegacyIndustryLoadDataCommand extends Command
{
    protected static $defaultName = 'app:legacy-industry:load-data';

    protected $clearer;
    protected $loader;

    public function __construct(Clearer $clearer, Loader $loader)
    {
        parent::__construct();

        $this->clearer = $clearer;
        $this->loader = $loader;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->text('Clearing old data.');
        $time = -microtime(true);
        $this->clearer->clear();
        $time += microtime(true);
        $io->success(sprintf('Cleared old data in %0.2fs.', $time));

        $io->text('Loading new data.');
        $time = -microtime(true);
        $this->loader->load();
        $time += microtime(true);
        $io->success(sprintf('Loaded new data in %0.2fs', $time));
    }
}

<?php

namespace COil\Jobeet2Bundle\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\DoctrineBundle\Command\DoctrineCommand;

class CleanCommand extends DoctrineCommand
{
    protected $input;
    protected $output;
    protected $siteBundles = array();
    protected $baseDir;

    /**
     * @see Command
     */
    protected function configure()
    {
        $this->setName('jobeet2:cleanup')
            ->setDescription('Clean the old Job offer wich where never published')
            ->addOption('days', null, InputOption::VALUE_REQUIRED, 'Days before now so the job is considered to be cleaned', 90)
        ;
    }

    /**
     * Main command function.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $output->writeln('<info>---- Jobeet2: Cleanup console command ----------</info>');

        $em   = $this->getEntityManager(null);
        $repo = $em->getRepository('Jobeet2Bundle:Job');
        $output->writeln(sprintf('<info> > Current environment: "%s"</info>', $input->getOption('env')));

        try {
            $cleanedJobs = $repo->cleanup($input->getOption('days'));
            if ($cleanedJobs > 0)
            {
                $output->writeln(sprintf('<info> > Successfully removed "%d" stale jobs from the database.</info>', $cleanedJobs));
            }
            else
            {
                $output->writeln('<info> > Database is already clean, nothing to delete.</info>');
            }

            $output->writeln('<info>---- Done --------------------------------------</info>');

        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>An error occured: %s</error>', $e->getMessage()));
        }
    }
}
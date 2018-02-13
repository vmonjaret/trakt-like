<?php

namespace AppBundle\Command;

use AppBundle\Manager\MovieManager;
use AppBundle\Utils\MovieDb;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppImportMoviesCommand extends ContainerAwareCommand
{
    private $movieDb;
    private $movieManager;
    private $em;

    public function __construct(?string $name = null, MovieDb $movieDb, MovieManager $movieManager, EntityManager $em)
    {
        parent::__construct($name);
        $this->movieDb = $movieDb;
        $this->movieManager = $movieManager;
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('app:import-movies')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Importing movies...');

        for ($i = 1; $i <= 10; $i++) {
            $results = $this->movieDb->getPopular($i);
            foreach ($results as $result) {
                $movie = $this->movieDb->getDetails($result['id']);
                $movie = $this->movieManager->createFromArray($movie);
                null === $movie ?: $this->em->persist($movie);
            }
            try {
                $this->em->flush();
            } catch (OptimisticLockException $e) {
                $output->writeln($e);
            }
        }

        $output->writeln('Movies imported.');
    }

}

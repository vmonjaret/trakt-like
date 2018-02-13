<?php

namespace AppBundle\Command;

use AppBundle\Entity\Movie;
use AppBundle\Manager\MovieManager;
use AppBundle\Utils\MovieDb;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshMoviesCommand extends ContainerAwareCommand
{
    private $em;
    private $movieDb;
    private $movieManager;

    public function __construct(?string $name = null, MovieDb $movieDb, MovieManager $movieManager, EntityManagerInterface $em)
    {
        parent::__construct($name);

        $this->em = $em;
        $this->movieDb = $movieDb;
        $this->movieManager = $movieManager;
    }


    protected function configure()
    {
        $this
            ->setName('app:refresh-movies')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Starting refresh');

        $movies = $this->em->getRepository(Movie::class)->findAll();

        $i = 1;
        foreach ($movies as $movie) {
            $output->writeln("{$i} movies refreshed");
            $i++;
            $tmp = $this->movieDb->getDetails($movie->getTmDbId());
            $movie = $this->movieManager->createFromArray($tmp);
            $this->em->merge($movie);
        }

        $this->em->flush();

        $output->writeln('Refresh done');
    }

}

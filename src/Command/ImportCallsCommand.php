<?php

namespace App\Command;

use App\Entity\Appel;
use App\Repository\AppelRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Filesystem\Filesystem;


class ImportCallsCommand extends Command
{
    const FLUSH_LIMIT = 200;

    private $em;

    /** @var AppelRepository */
    private $appelRepository;

    public function __construct(EntityManagerInterface $em, AppelRepository $appelRepository)
    {
        parent::__construct();

        $this->em = $em;
        $this->appelRepository = $appelRepository;
    }

    protected function configure()
    {
        $this
            ->setName('app:import:calls')
            ->setDescription("Commande qui importe les appels depuis un csv")
            ->addOption(
                'file',
                null,
                InputOption::VALUE_REQUIRED,
                'Fichier à importer'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Import des appels : ');

        $io->title('Chargement des appels');

        /** @var Reader $callReader */

        $file = $input->getOption('file');

        if($file){
            $filesystem = new Filesystem();
            if($filesystem->exists($file)){
                $io->success("Le fichier ".$file." a été trouvé");
                $callReader = Reader::createFromPath($file);
                $io->success("Le fichier ".$file." est chargé");
            }else{
                $io->error("Le fichier ".$file." n'existe pas");
                exit();
            }
        }else{
            $callReader = Reader::createFromPath('%kernel.root_dir%/../src/Data/calls.csv');
        }


        $callReader->setDelimiter(';');

        $results = $callReader->getIterator();

        $io->progressStart(iterator_count($results));

        $i=0;
        foreach ($results as $index => $row) {

            if ($index > 2) {
                $this->putCall($row);
            }

            $i++;

            if ($i % self::FLUSH_LIMIT == 0){
                $io->progressAdvance(self::FLUSH_LIMIT);
                $this->em->flush();
                $this->em->clear();
            }


        }

        $this->em->flush();
        $this->em->clear();
        $io->progressFinish();
        $io->success('Appels enregistrés');
    }

    private function putCall(Array $row){
        $newCall = new Appel();
        $newCall->setCompteFacture($row[0]);
        $newCall->setNumFacture($row[1]);
        $newCall->setNumAbonne($row[2]);
        $newCall->setDate(\DateTime::createFromFormat('d/m/Y', $row[3]));
        if (\DateTime::createFromFormat('H:i:s', $row[4])) {
            $newCall->setHeure(\DateTime::createFromFormat('H:i:s', $row[4]));
        } else {
            $newCall->setHeure(\DateTime::createFromFormat('H:i:s', "00:00:00"));
        }
        $newCall->setDureeVolumeReel($row[5]);
        $newCall->setDureeVolumeFacture($row[6]);
        $newCall->setType(UTF8_decode($row[7]));
        //$newCall->setType('');
        $this->em->persist($newCall);
    }
}

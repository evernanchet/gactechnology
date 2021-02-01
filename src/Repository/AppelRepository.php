<?php

namespace App\Repository;

use App\Entity\Appel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Appel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appel[]    findAll()
 * @method Appel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appel::class);
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findDurationCalls(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT SUM(duree_volume_reel) FROM appel
            WHERE type like "%appel%"
            AND date >= "15/02/2012"
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findTopData(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM appel
            WHERE type like "%connexion%"
            AND heure between "08:00:00" and "18:00:00"
            ORDER BY duree_volume_facture DESC
            GROUP BY num_abonne
            LIMIT 10
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findSmsSent(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT COUNT(duree_volume_reel) FROM appel
            WHERE type like "%sms%"
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }
}

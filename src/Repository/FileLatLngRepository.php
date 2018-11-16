<?php

namespace App\Repository;

use App\Entity\FileLatLng;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FileLatLng|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileLatLng|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileLatLng[]    findAll()
 * @method FileLatLng[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileLatLngRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FileLatLng::class);
    }

    // /**
    //  * @return FileLatLng[] Returns an array of FileLatLng objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FileLatLng
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

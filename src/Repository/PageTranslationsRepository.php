<?php

namespace App\Repository;

use App\Entity\PageTranslations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PageTranslations|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageTranslations|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageTranslations[]    findAll()
 * @method PageTranslations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageTranslationsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PageTranslations::class);
    }

}

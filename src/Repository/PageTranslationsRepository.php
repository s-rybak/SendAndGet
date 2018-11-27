<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\PageTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PageTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageTranslation[]    findAll()
 * @method PageTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageTranslationsRepository extends ServiceEntityRepository implements PageTranslationsRepositoryInterface
{
    use RepositoryStandartFunctionsTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PageTranslation::class);
    }

    public function getByPageId(int $id, string $locale = 'en'): ?PageTranslation
    {
        return $this->findOneBy(['translatable_id' => $id, 'locale' => $locale]);
    }
}

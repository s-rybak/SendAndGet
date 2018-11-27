<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository implements PageRepositoryInterface
{
    use RepositoryStandartFunctionsTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function getBySlug(string $slug): ?Page
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function save($page): Page
    {
        $em = $this->getEntityManager();
        $em->persist($page);
        $page->mergeNewTranslations();
        $em->flush();

        return $page;
    }
}

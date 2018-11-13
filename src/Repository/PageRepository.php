<?php

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
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /**
     * @param int    $page
     * @param int    $perpage
     * @param string $lang
     *
     * @return Page[] Returns an array of Page objects
     */
    public function getList(int $page, int $perpage = 10): iterable
    {
        return $this->findAll();
    }

    public function getById(int $id): ?Page
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function getBySlug(string $slug): ?Page
    {
        return $this->findOneBy(['slug' => $slug]);
    }
}

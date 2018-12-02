<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\ApiApp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ApiApp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiApp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiApp[]    findAll()
 * @method ApiApp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiAppRepository extends ServiceEntityRepository implements ApiAppRepositoryInterface
{
    use RepositoryStandartFunctionsTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ApiApp::class);
    }

    public function getByKey(string $key): ?ApiApp
    {
        $key_type = 0 === strpos($key, 'live_') ? 'live_key' : 'test_key';

        return $this->findOneBy([$key_type => $key, 'status' => ['active', 'suspended']]);
    }

    public function getByStatus(string $status, int $page = 1, int $perpage = 10): iterable
    {
        return $this->findBy(['status' => $status], null, $perpage, ($page - 1) * $perpage);
    }

    public function getAppCallsCount(): int
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('SUM(a.calls_count)');

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}

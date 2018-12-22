<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\ApiApp;

/**
 * @method ApiApp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiApp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiApp[]    findAll()
 * @method ApiApp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
trait RepositoryStandartFunctionsTrait
{
    public function save($app)
    {
        $em = $this->getEntityManager();
        $em->persist($app);
        $em->flush();

        return $app;
    }

    public function remove($entity): void
    {
        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();
    }

    public function getById(int $id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function getList(int $page, int $perpage = 10): iterable
    {
        return $this->findBy([], null, $perpage, ($page - 1) * $perpage);
    }

    public function length(): int
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('COUNT(a)');

        return intval($qb->getQuery()->getSingleScalarResult());
    }

	public function saveMany(array $entities): array
	{
		$em = $this->getEntityManager();
		$em->getConnection()->beginTransaction();

		try {
			foreach ($entities as $entity) {
				$em->persist($entity);
				$em->flush();
			}
			$em->getConnection()->commit();
		} catch (\Exception $e) {
			$em->getConnection()->rollBack();
			throw $e;
		}

		return $entities;
	}
}

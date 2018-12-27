<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method File|null find( $id, $lockMode = null, $lockVersion = null )
 * @method File|null findOneBy( array $criteria, array $orderBy = null )
 * @method File[]    findAll()
 * @method File[]    findBy( array $criteria, array $orderBy = null, $limit = null, $offset = null )
 */
class FileRepository extends ServiceEntityRepository implements FileRepositiryInterface
{
    use RepositoryStandartFunctionsTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, File::class);
    }

    /**
     * Saves array of files.
     *
     * @param array $files
     *
     * @return array
     *
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Exception
     */
    public function saveMany(array $files): array
    {
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();

        try {
            foreach ($files as $file) {
                $em->persist($file);
                $em->flush();
            }
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollBack();
            throw $e;
        }

        return $files;
    }

    public function getByHash(string $hash): ?File
    {
        return $this->findOneBy(['hash' => $hash]);
    }

    public function getByGroupHash(string $group_hash): iterable
    {
        return $this->findBy(['group_hash' => $group_hash, 'status' => 'active']);
    }

    public function getByAppId(int $id, int $page = 1, int $perpage = 10): iterable
    {
        return $this->findBy(['app_id' => $id], null, $perpage, ($page - 1) * $perpage);
    }

    public function getByUserId(int $id, int $page = 1, int $perpage = 10): iterable
    {
        return $this->findBy(['user_id' => $id], null, $perpage, ($page - 1) * $perpage);
    }

    public function getQueryByHash(int $id, string $hash, int $page = 1, int $perpage = 10): iterable
    {
        $files = $this->findBy([
            'hash' => $hash,
            'app_id' => $id,
            'status' => ['active', 'blocked', 'reported'],
        ]);
        $filesGroup = $this->findBy([
            'group_hash' => $hash,
            'app_id' => $id,
            'status' => ['active', 'blocked', 'reported'],
        ], null, $perpage, ($page - 1) * $perpage);

        return count($filesGroup) > 0 ? $filesGroup : (0 == count($files) ? [] : $files);
    }

    public function getExpired(int $limit): iterable
    {
        $qb = $this->createQueryBuilder('f');
        $qb
            ->where('f.deletes_in <= CURRENT_TIMESTAMP()')
            ->andWhere("f.status IN ('active','blocked','reported')");

        return $qb->getQuery()
                  ->getResult();
    }

    public function getDeletedExpired(int $limit): iterable
    {
        $qb = $this->createQueryBuilder('f');
        $qb
            ->where('f.deletes_in <= CURRENT_TIMESTAMP()')
            ->andWhere("f.status IN ('deleted')");

        return $qb->getQuery()
                  ->getResult();
    }

    public function expireAppFiles(int $appId): void
    {
        $this
            ->createQueryBuilder('f')
            ->update()
            ->set('f.deletes_in', ':date')
            ->where('f.app_id = :id')
            ->setParameter('id', $appId)
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->execute();
    }

    public function expireByUser(int $user_id): void
    {
        $this
            ->createQueryBuilder('f')
            ->update()
            ->set('f.deletes_in', ':date')
            ->set('f.status', ':status')
            ->where('f.user_id = :id')
            ->setParameter('id', $user_id)
            ->setParameter('date', new \DateTime())
	        ->setParameter('status', "deleted")
            ->getQuery()
            ->execute();
    }

    public function expireByUserIds(array $user_ids): void
    {
        $this
            ->createQueryBuilder('f')
            ->update()
            ->set('f.deletes_in', ':date')
            ->set('f.status', ':status')
            ->where('f.user_id IN (:ids)')
            ->setParameter('ids', $user_ids)
            ->setParameter('date', new \DateTime())
            ->setParameter('status', "deleted")
            ->getQuery()
            ->execute();
    }

    public function getFilesSize(int $id = 0): int
    {
        $qb = $this->createQueryBuilder('a');

        if ($id > 0) {
            $qb->where('a.app_id = :id')
               ->setParameter('id', $id);
        }

        $qb->select('SUM(a.size)');

        return intval($qb->getQuery()->getSingleScalarResult());
    }

    public function getFilesCount(int $id = 0): int
    {
        if ($id > 0) {
            $qb = $this->createQueryBuilder('a');
            $qb->where('a.app_id = :id');
            $qb->select('COUNT(a)');
            $qb->setParameter('id', $id);

            return intval($qb->getQuery()->getSingleScalarResult());
        }

        return $this->length();
    }

	public function setStatusByUserId( int $id = 0, string $status ): void {

		$this
			->createQueryBuilder('f')
			->update()
			->set('f.status', ':status')
			->where('f.user_id = :user_id')
			->setParameter('user_id', $id)
			->setParameter('status', $status)
			->getQuery()
			->execute();

	}

	public function setStatusByUserIdPack( array $ids, string $status ): void {

		$this
			->createQueryBuilder('f')
			->update()
			->set('f.status', ':status')
			->where('f.user_id IN (:user_ids)')
			->setParameter('user_ids', $ids)
			->setParameter('status', $status)
			->getQuery()
			->execute();

	}
}

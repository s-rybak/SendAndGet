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
 * @method File|null find($id, $lockMode = null, $lockVersion = null)
 * @method File|null findOneBy(array $criteria, array $orderBy = null)
 * @method File[]    findAll()
 * @method File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
        return $this->findBy(['group_hash' => $group_hash,'status'=>'active']);
    }

    public function getByAppId(int $id, int $page = 1, int $perpage = 10): iterable
    {
        return $this->findBy(['app_id' => $id], null, $perpage, ($page - 1) * $perpage);
    }

    public function getQueryByHash(int $id, string $hash, int $page = 1, int $perpage = 10): iterable
    {
        $files = $this->findBy(['hash' => $hash, 'app_id' => $id, 'status' => ['active', 'blocked', 'reported']]);
        $filesGroup = $this->findBy(['group_hash' => $hash, 'app_id' => $id, 'status' => ['active', 'blocked', 'reported']], null, $perpage, ($page - 1) * $perpage);

        return count($filesGroup) > 0 ? $filesGroup : (0 == count($files) ? [] : $files);
    }
}

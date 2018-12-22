<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\FileUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FileUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileUser[]    findAll()
 * @method FileUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileUserRepository extends ServiceEntityRepository implements FileUserRepositoryInterface
{
    use RepositoryStandartFunctionsTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FileUser::class);
    }

	public function getByFileID( int $id, int $page = 1, int $perpage = 10 ):iterable {

		return $this->findBy(['file_id'=>$id]);

	}

	public function getByUserID( int $id, int $page = 1, int $perpage = 10 ):iterable {

		return $this->findBy(['user_id'=>$id]);

	}

	public function getByFileAndUserId(int $file_id,int $user_id): ?FileUser {

		return $this->findOneBy(['file_id'=>$file_id,'user_id'=>$user_id]);

	}
}

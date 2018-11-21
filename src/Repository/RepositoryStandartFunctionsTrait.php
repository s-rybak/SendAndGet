<?php

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
trait RepositoryStandartFunctionsTrait
{

	public function save( $app ){

		$em = $this->getEntityManager();
		$em->persist($app);
		$em->flush();

		return $app;
	}


	public function remove( $entity ): void {

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
		return $this->findBy([],null,$perpage,($page-1)*$perpage);
	}
}

<?php

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
	 * Saves array of files
	 *
	 * @param array $files
	 *
	 * @return array
	 * @throws \Doctrine\DBAL\ConnectionException
	 * @throws \Exception
	 */
	public function saveMany( array $files ): array {

    	$em = $this->getEntityManager();
		$em->getConnection()->beginTransaction();

		try {
			foreach ($files as $file){

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
}

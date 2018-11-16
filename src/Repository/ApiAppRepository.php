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
class ApiAppRepository extends ServiceEntityRepository implements ApiAppRepositoryInterface
{

	use RepositoryStandartFunctionsTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ApiApp::class);
    }

	public function getByKey( string $key ): ?ApiApp {

		$key_type = strpos( $key, 'live_' ) === 0 ? 'live_key' : 'test_key';

		return $this->findOneBy( [ $key_type => $key ] );

	}
}

<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\FileUserRepositoryInterface;
use App\Repository\UserRpositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class UserService implements UserServiceInterface {

	private $repo;
	private $fileUserRepo;

	public function __construct( UserRpositoryInterface $repository, FileUserRepositoryInterface $fileUserRepo ) {

		$this->repo = $repository;
		$this->fileUserRepo = $fileUserRepo;

	}

	public function save( User $user ): User {

		return $this->repo->save( $user );

	}

	public function remove( User $user ): void {

		$this->repo->remove( $user );

	}

	public function getById( int $id ): ?User {

		return $this->repo->getById( $id );

	}

	public function getAll( int $page, int $perpage = 10 ): iterable {

		return $this->repo->getList( $page, $perpage );

	}

	public function getCreateServiceUser( Request $request ): User {

		return $this->repo->getCreateServiceUser( implode( ",", $request->getClientIps() ), $request->server->get( 'HTTP_USER_AGENT' ) );

	}

	public function getByStatus( string $status, int $page = 1, int $perpage = 10 ): iterable {

		return $this->repo->getByStatus( $status, $page, $perpage );

	}

	public function getByIp( string $ip , int $page = 1, int $perpage = 10): iterable {

		return $this->repo->getByIp($ip,$page,$perpage);

	}

	public function getDownloads( int $page = 1, int $perpage = 10): iterable {

		return $this->fileUserRepo->getDownloaded($page,$perpage);

	}

	public function setStatusByIp( string $ip, string $status ): void {

		$this->repo->setStatusByIp($ip,$status);

	}
}
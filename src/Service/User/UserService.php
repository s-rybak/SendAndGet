<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRpositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class UserService implements UserServiceInterface {

	private $repo;

	public function __construct( UserRpositoryInterface $repository ) {

		$this->repo = $repository;

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
}
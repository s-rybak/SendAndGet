<?php

namespace App\Service\User;

use App\Entity\File;
use App\Entity\FileUser;
use App\Entity\User;
use App\Repository\FileUserRepositoryInterface;

class FileUserService implements FileUserServiceIntervface {

	private $fileUserRepo;

	public function __construct( FileUserRepositoryInterface $repository ) {

		$this->fileUserRepo = $repository;

	}

	public function addDownload( User $user, File $file ): FileUser {


		return $this->fileUserRepo->save( $this->updateDownloadCount($user,$file) );

	}

	public function addDownloadMany( User $user, array $files ): iterable {

		$save = [];

		foreach ( $files as $file ) {

			$save[] = $this->updateDownloadCount($user,$file);

		}

		return $this->fileUserRepo->saveMany($save);

	}

	private function updateDownloadCount(User $user, File $file):FileUser
	{

		$fileUser = $this->fileUserRepo->getByFileAndUserId( $file->getId(), $user->getId() );

		if ( null === $fileUser ) {

			$fileUser = new FileUser();

		}

		$fileUser->setCount( $fileUser->getCount() + 1 );
		$fileUser->setUserId( $user->getId() );
		$fileUser->setFileId( $file->getId() );
		$fileUser->setStatus( "downloaded" );

		return $fileUser;

	}


	public function getByUserId( int $id, int $page = 1, int $perpage = 10 ): iterable {

		return $this->fileUserRepo->getByUserID($id,$page,$perpage);

	}

	public function getByFileId( int $id, int $page = 1, int $perpage = 10 ): iterable {

		return $this->fileUserRepo->getByFileID($id,$page,$perpage);

	}

}
<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Files;

use App\Entity\ApiApp;
use App\Entity\File;
use App\DTO\FileBagSizeDTO;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\FilesRemoveExceptionsPack;
use App\Repository\FileRepositiryInterface;
use App\Service\User\FileUserServiceIntervface;
use App\Transformer\UploadedFileToFileTransformer;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipStream\ZipStream;

class FilesService implements FilesServiceInterface {
	private $uploader;
	private $transformer;
	private $repositiry;
	private $uploadDir;
	private $fileLifeTime;
	private $fileUserService;

	public function __construct(
		FileUploaderInterface $file_uploader,
		UploadedFileToFileTransformer $transformer,
		FileRepositiryInterface $repositiry,
		$uploadDir,
		$fileLifeTime
	) {
		$this->uploader     = $file_uploader;
		$this->transformer  = $transformer;
		$this->repositiry   = $repositiry;
		$this->uploadDir    = $uploadDir;
		$this->fileLifeTime = $fileLifeTime;
	}

	public function uploadFiles( int $appId, FileBag $files, string $group_hash, int $user_id ): iterable {
		$filesArray = [];

		$this->uploader->setAppId( $appId );
		$this->uploader->setGroupHash( $group_hash );
		$this->uploader->setFileLifeTime( $this->fileLifeTime );
		$this->uploader->setUserId( $user_id );

		foreach ( $files as $file ) {
			$filesArray[] = $this->transformer->getFile(
				$this->uploader->upload( $file )
			);
		}

		return $filesArray;
	}

	public function saveFiles( array $files ): iterable {
		return $this->repositiry->saveMany( $files );
	}

	public function uploadAndSaveFiles( int $appId, FileBag $files, string $group_hash, int $user_id ): iterable {
		return $this->saveFiles(
			$this->uploadFiles( $appId, $files, $group_hash, $user_id )
		);
	}

	public function getById( int $id ): ?File {
		return $this->repositiry->getById( $id );
	}

	public function getByHash( string $hash ): ?File {
		return $this->repositiry->getByHash( $hash );
	}

	public function zipFiles( string $group_hash ): StreamedResponse {
		$files = $this->repositiry->getByGroupHash( $group_hash );

		if ( null == $files && 0 === count( $files ) ) {
			throw new EntityNotFoundException( "Group $group_hash not found" );
		}

		$response = new StreamedResponse( function () use ( $files, $group_hash ) {
			$zip = new ZipStream( $group_hash . '.zip' );

			foreach ( $files as $f ) {
				$zip->addFileFromPath( $f->getName(), $this->uploadDir . $f->getPath() . $f->getName() );
			}

			$zip->finish();
		} );

		return $response;
	}

	public function zipFilesPack( iterable $files, string $group_hash ): StreamedResponse {

		if ( null == $files && 0 === count( $files ) ) {
			throw new EntityNotFoundException( "Group $group_hash not found" );
		}

		$response = new StreamedResponse( function () use ( $files, $group_hash ) {
			$zip = new ZipStream( $group_hash . '.zip' );

			foreach ( $files as $f ) {
				$zip->addFileFromPath( $f->getName(), $this->uploadDir . $f->getPath() . $f->getName() );
			}

			$zip->finish();
		} );

		return $response;
	}

	public function getByAppId( int $id, int $page = 1, int $perpage = 10 ): iterable {
		return $this->repositiry->getByAppId( $id, $page, $perpage );
	}

	public function getByUserId( int $id, int $page = 1, int $perpage = 10 ): iterable {
		return $this->repositiry->getByUserId( $id, $page, $perpage );
	}

	public function getQueryByHash( int $id, string $hash, int $page = 1, int $perpage = 10 ): iterable {
		return $this->repositiry->getQueryByHash( $id, $hash, $page, $perpage );
	}

	public function getAll( int $page = 1, int $perpage = 10 ): iterable {
		return $this->repositiry->getList( $page, $perpage );
	}

	public function save( File $file ): File {
		return $this->repositiry->save( $file );
	}

	public function remove( File $file, $soft = true ) {
		$this->repositiry->remove( $file );

		if ( ! $soft ) {
			$path = $this->uploadDir . $file->getPath() . $file->getName();

			unlink( $path );
		}
	}

	public function removeMany( iterable $files, $soft = true ) {

		$errors = [];
		$errorsMsgs = "";

		foreach ( $files as $i => $file ) {

			try {

				$this->repositiry->remove( $file );

				if ( ! $soft ) {
					$path = $this->uploadDir . $file->getPath() . $file->getName();

					unlink( $path );
				}

			} catch ( \Exception $e ) {

				$errors[] = $e;
				$errorsMsgs .= "#$i: ".$e->getMessage(). "\n";

			}

		}

		if(count($errors) > 0){

			$eception = new FilesRemoveExceptionsPack();
			$eception->setErrors($errors);
			throw $eception;

		}

	}

	public function prolong( File $file ) {
		$this->save(
			$file
				->setAviableAt( new \DateTime() )
				->setDeletesIn(
					new \DateTime( "+{$file->getLifeTime()} day" )
				)
		);
	}

	public function expire( File $file ) {
		$this->save(
			$file
				->setDeletesIn( new \DateTime() )
		);
	}

	public function getExpired( int $limit ): iterable {
		return $this->repositiry->getExpired( $limit );
	}

	public function getDeletedExpired( int $limit ): iterable {
		return $this->repositiry->getDeletedExpired( $limit );
	}

	public function expireAppFiles( int $appId ) {
		$this->repositiry->expireAppFiles( $appId );
	}

	public function expireByUser( int $user_id ): void {
		$this->repositiry->expireByUser( $user_id );
	}

	public function expireByUserIds( array $user_ids ): void {
		$this->repositiry->expireByUserIds( $user_ids );
	}

	public function getFileBagSize( FileBag $flies ): FileBagSizeDTO {
		$size = new FileBagSizeDTO();

		foreach ( $flies as $file ) {
			$size->countFile( $file->getClientSize() / 1000000, $file->getClientOriginalName() );
		}

		return $size;
	}

	public function changeAppLimits( ApiApp $app, FileBag $flies ): ApiApp {
		$size = $this->getFileBagSize( $flies );

		if ( $app->getStorage() < $size->getSize() ) {
			$sz = number_format( $size->getSize(), 2 );

			throw new \Exception( "App storage exceeded ( You try to upload {$sz} Mb ). Storage left: {$app->getStorage()} Mb" );
		}

		if ( $app->getLimits() < $size->getMaxFileSize() ) {
			$sz = number_format( $size->getMaxFileSize(), 2 );

			throw new \Exception( "App max file ({$size->getMaxFileName()} : {$sz} Mb) size exceeded. Max size: {$app->getLimits()} Mb" );
		}

		return $app->setStorage( $app->getStorage() - $size->getSize() );
	}

	public function getByGroupHash( string $hash ): iterable {

		return $this->repositiry->getByGroupHash( $hash );

	}

	public function setStatusByUserId( int $id = 0, string $status ): void {

		$this->repositiry->setStatusByUserId( $id, $status );

	}

	public function setStatusByUserIdPack( array $ids, string $status ): void {

		$this->repositiry->setStatusByUserIdPack( $ids, $status );

	}
}

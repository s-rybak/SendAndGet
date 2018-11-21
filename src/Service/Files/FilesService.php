<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/15/18
 * Time: 12:20 PM
 */

namespace App\Service\Files;

use App\Entity\File;
use App\Exceptions\EntityNotFoundException;
use App\Repository\FileRepositiryInterface;
use App\Transformer\UploadedFileToFileTransformer;
use Symfony\Component\HttpFoundation\FileBag;

class FilesService implements FilesServiceInterface {

	private $uploader;
	private $transformer;
	private $repositiry;
	private $uploadDir;

	public function __construct(
		FileUploaderInterface $file_uploader,
		UploadedFileToFileTransformer $transformer,
		FileRepositiryInterface $repositiry,
		$uploadDir
	) {

		$this->uploader    = $file_uploader;
		$this->transformer = $transformer;
		$this->repositiry  = $repositiry;
		$this->uploadDir   = $uploadDir;

	}

	public function uploadFiles( int $appId, FileBag $files, string $group_hash ): iterable {

		$filesArray = [];

		$this->uploader->setAppId( $appId );
		$this->uploader->setGroupHash( $group_hash );

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

	public function uploadAndSaveFiles( int $appId, FileBag $files, string $group_hash ): iterable {
		return $this->saveFiles( $this->uploadFiles( $appId, $files, $group_hash ) );
	}

	public function getById( int $id ): ?File {

		return $this->repositiry->getById( $id );

	}

	public function getByHash( string $hash ): ?File {

		return $this->repositiry->getByHash( $hash );

	}

	public function zipFiles( string $group_hash ): string {

		$files = $this->repositiry->getByGroupHash( $group_hash );

		if ( null == $files && count($files) === 0) {

			throw new EntityNotFoundException( "Group $group_hash not found" );

		}

		$zip     = new \ZipArchive();
		$zipName = $this->uploadDir . $files[0]->getPath() . "all.zip";
		$zip->open( $zipName, \ZipArchive::CREATE );
		foreach ( $files as $f ) {
			$zip->addFromString( $f->getName(), file_get_contents( $this->uploadDir . $f->getPath() . $f->getName() ) );
		}
		$zip->close();

		return $zipName;

	}

	public function getByAppId( int $id, int $page = 1, int $perpage = 10 ): iterable {

		return $this->repositiry->getByAppId($id,$page,$perpage);

	}

	public function getQueryByHash(int $id, string $hash, int $page = 1, int $perpage = 10 ): iterable {

		return $this->repositiry->getQueryByHash($id,$hash,$page,$perpage);

	}

	public function getAll(int $page = 1, int $perpage = 10 ): iterable {

		return $this->repositiry->getList($page,$perpage);

	}

	public function save( File $file ): File {

		return $this->repositiry->save($file);

	}

	public function remove( File $file ) {

		$this->repositiry->remove($file);

	}
}
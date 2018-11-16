<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/15/18
 * Time: 12:20 PM
 */

namespace App\Service\Files;

use App\Repository\FileRepositiryInterface;
use App\Transformer\UploadedFileToFileTransformer;
use Symfony\Component\HttpFoundation\FileBag;

class FilesService implements FilesServiceInterface {

	private $uploader;
	private $transformer;
	private $repositiry;

	public function __construct(
		FileUploaderInterface $file_uploader,
		UploadedFileToFileTransformer $transformer,
		FileRepositiryInterface $repositiry
	) {

		$this->uploader    = $file_uploader;
		$this->transformer = $transformer;
		$this->repositiry  = $repositiry;

	}

	public function uploadFiles( int $appId, FileBag $files ): iterable {

		$filesArray = [];

		$this->uploader->setAppId( $appId );

		foreach ( $files as $file ) {

			$filesArray[] = $this->transformer->getFile(
				$this->uploader->upload( $file )
			);

		}

		return $filesArray;

	}

	public function saveFiles( array $files ): iterable {

		return $this->repositiry->saveMany($files);

	}

	public function uploadAndSaveFiles( int $appId, FileBag $files ): iterable {
		return $this->saveFiles( $this->uploadFiles( $appId, $files ) );
	}


}
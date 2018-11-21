<?php

namespace App\Transformer;

use App\DTO\UploadedFileDTO;
use App\Entity\File;

class UploadedFileToFileTransformer {

	public function getFile( UploadedFileDTO $file_DTO ): File {

		$file = new File();
		$file->setName( $file_DTO->getFileName() );
		$file->setPath( $file_DTO->getFilePath() );
		$file->setType( $file_DTO->getExt() );
		$file->setAppId( $file_DTO->getAppId() );
		$file->setStatus( $file_DTO->getStatus() );
		$file->setGroupHash( $file_DTO->getGroupHash() );

		return $file;

	}

}
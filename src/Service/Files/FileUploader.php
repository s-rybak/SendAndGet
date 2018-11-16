<?php
namespace App\Service\Files;

use App\DTO\UploadedFileDTO;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader implements FileUploaderInterface
{
	private $targetDirectory;
	private $appId;

	public function __construct($targetDirectory)
	{
		$this->targetDirectory = $targetDirectory;
	}

	public function setAppId(int $app_id):void{

		$this->appId = $app_id;

	}

	public function upload(UploadedFile $file): UploadedFileDTO
	{

		$fileName = md5(uniqid()).'.'.$file->guessExtension();
		$filePath = $this->appId."/".md5(time())."/";

		$file->move($this->getTargetDirectory().$filePath, $fileName);

		$uploadedFile = new UploadedFileDTO(
			$fileName,
			$filePath,
			$file->guessExtension(),
			$this->appId
		);

		return $uploadedFile;
	}

	public function getTargetDirectory(): string
	{
		return $this->targetDirectory;
	}
}
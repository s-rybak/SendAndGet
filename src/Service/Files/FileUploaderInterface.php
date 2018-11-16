<?php
namespace App\Service\Files;

use App\DTO\UploadedFileDTO;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * File uploader interface
 * Provides upload file functionality
 * @package App\Service\Files
 */
interface FileUploaderInterface {

	public function setAppId(int $app_id):void;

	public function upload(UploadedFile $file):UploadedFileDTO;

	public function getTargetDirectory():string;

}
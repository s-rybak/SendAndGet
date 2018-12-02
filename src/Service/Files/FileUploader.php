<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Files;

use App\DTO\UploadedFileDTO;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader implements FileUploaderInterface
{
    private $targetDirectory;
    private $appId;
    private $groupHash;
    private $fileLifeTime;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
        $this->groupHash = uniqid();
    }

    public function upload(UploadedFile $file): UploadedFileDTO
    {
        $ext = $file->guessExtension();
        $fileName = uniqid().'.'.$ext;
        $filePath = $this->appId.'/'.uniqid().'/';

        $file->move($this->getTargetDirectory().$filePath, $fileName);

        $uploadedFile = new UploadedFileDTO(
            $fileName,
            $filePath,
            $ext,
            'active',
            $this->getGroupHash(),
	        $this->fileLifeTime,
	        $file->getSize(),
            $this->getAppId()
        );

        return $uploadedFile;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    /**
     * @param string $group_hash
     */
    public function setGroupHash(string $group_hash): void
    {
        $this->groupHash = $group_hash;
    }

    /**
     * @return string
     */
    public function getGroupHash(): string
    {
        return $this->groupHash;
    }

    public function setAppId(int $app_id): void
    {
        $this->appId = $app_id;
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

	/**
	 * @param int $fileLifeTime
	 */
	public function setFileLifeTime(int $fileLifeTime ): void {
		$this->fileLifeTime = $fileLifeTime;
	}
}

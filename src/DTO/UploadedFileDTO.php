<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DTO;

/**
 * Uploaded file DTO.
 *
 * Contains file data
 * wich uploaded using
 * file uploader service
 */
final class UploadedFileDTO
{
    private $fileName;
    private $filePath;
    private $ext;
    private $app_id;
    private $status;
    private $groupHash;
    private $fileLifeTime;
    private $size;
    private $userId;

    public function __construct(
        string $fileName,
        string $filePath,
        string $ext,
        string $status,
        string $groupHash,
        int $fileLifeTime,
        int $size,
        int $app_id
    ) {
        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->ext = $ext;
        $this->app_id = $app_id;
        $this->status = $status;
        $this->groupHash = $groupHash;
        $this->fileLifeTime = $fileLifeTime;
        $this->size = $size;
        $this->userId = 0;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     */
    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getExt(): string
    {
        return $this->ext;
    }

    /**
     * @param string $ext
     */
    public function setExt(string $ext): void
    {
        $this->ext = $ext;
    }

    /**
     * @return int
     */
    public function getAppId(): int
    {
        return $this->app_id;
    }

    /**
     * @param int $app_id
     */
    public function setAppId(int $app_id): void
    {
        $this->app_id = $app_id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getGroupHash(): string
    {
        return $this->groupHash;
    }

    /**
     * @param string $groupHash
     */
    public function setGroupHash(string $groupHash): void
    {
        $this->groupHash = $groupHash;
    }

    /**
     * @return int
     */
    public function getFileLifeTime(): int
    {
        return $this->fileLifeTime;
    }

    /**
     * @param int $fileLifeTime
     */
    public function setFileLifeTime(int $fileLifeTime): void
    {
        $this->fileLifeTime = $fileLifeTime;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

	/**
	 * @return int
	 */
	public function getUserId():int
	{
		return $this->userId;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId( int $userId ): void {
		$this->userId = $userId;
	}
}

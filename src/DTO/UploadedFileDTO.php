<?php
namespace App\DTO;

/**
 * Uploaded file DTO
 *
 * Contains file data
 * wich uploaded using
 * file uploader service
 *
 * @package App\DTO
 */
final class UploadedFileDTO {

	private $fileName;
	private $filePath;
	private $ext;
	private $app_id;

	public function __construct(
		string $fileName,
		string $filePath,
		string $ext,
		int $app_id
	) {

		$this->fileName = $fileName;
		$this->filePath = $filePath;
		$this->ext = $ext;
		$this->app_id = $app_id;

	}

	/**
	 * @return string
	 */
	public function getFileName(): string {
		return $this->fileName;
	}

	/**
	 * @param string $fileName
	 */
	public function setFileName( string $fileName ): void {
		$this->fileName = $fileName;
	}

	/**
	 * @return string
	 */
	public function getFilePath(): string {
		return $this->filePath;
	}

	/**
	 * @param string $filePath
	 */
	public function setFilePath( string $filePath ): void {
		$this->filePath = $filePath;
	}

	/**
	 * @return string
	 */
	public function getExt(): string {
		return $this->ext;
	}

	/**
	 * @param string $ext
	 */
	public function setExt( string $ext ): void {
		$this->ext = $ext;
	}

	/**
	 * @return int
	 */
	public function getAppId(): int {
		return $this->app_id;
	}

	/**
	 * @param int $app_id
	 */
	public function setAppId( int $app_id ): void {
		$this->app_id = $app_id;
	}

}
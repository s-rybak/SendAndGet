<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/16/18
 * Time: 1:01 AM
 */

namespace App\DTO;

/**
 * Contains js sdk necessary data
 * @package App\DTO
 */
class JsSdkDTO {

	private $api_key;
	private $max_files_count;
	private $upload_url;

	public function __construct(
		string $api_key,
		string $upload_url,
		int $max_files_count
	) {

		$this->api_key = $api_key;
		$this->max_files_count = $max_files_count;
		$this->upload_url = $upload_url;

	}

	/**
	 * @return mixed
	 */
	public function getApiKey():string {
		return $this->api_key;
	}

	/**
	 * @param string $api_key
	 */
	public function setApiKey(string $api_key ): void {
		$this->api_key = $api_key;
	}

	/**
	 * @return mixed
	 */
	public function getMaxFilesCount():int {
		return $this->max_files_count;
	}

	/**
	 * @param int $max_files_count
	 */
	public function setMaxFilesCount(int $max_files_count ): void {
		$this->max_files_count = $max_files_count;
	}

	/**
	 * @return mixed
	 */
	public function getUploadUrl():string {
		return $this->upload_url;
	}

	/**
	 * @param mixed $upload_url
	 */
	public function setUploadUrl( string $upload_url ): void {
		$this->upload_url = $upload_url;
	}


}
<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/16/18
 * Time: 1:11 AM
 */

namespace App\Service;


use App\DTO\JsSdkDTO;

class JsSdkService implements JsSdkServiceInterface{

	public function getJsSdkDto( string $api ): JsSdkDTO {

		return new JsSdkDTO(
			$api,
			"/api/files/upload",
			10,
			"/api/files/list",
			"/api/files/query",
			"api/files/delete"
		);

	}

}
<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/16/18
 * Time: 1:04 AM
 */

namespace App\Service;

use App\DTO\JsSdkDTO;

/**
 * Provides js sdk service functions
 *
 * @package App\Service
 */

interface JsSdkServiceInterface {

	public function getJsSdkDto(string $api):JsSdkDTO;

}
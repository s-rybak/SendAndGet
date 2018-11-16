<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/15/18
 * Time: 12:11 PM
 */

namespace App\Service\Files;

use Symfony\Component\HttpFoundation\FileBag;

/**
 * Provides File
 * service functionality
 * @package App\Service
 */
interface FilesServiceInterface {

	public function uploadFiles(int $appId,FileBag $files):iterable;
	public function saveFiles(array $files):iterable;
	public function uploadAndSaveFiles(int $appId,FileBag $files):iterable;

}
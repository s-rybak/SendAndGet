<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/15/18
 * Time: 12:11 PM
 */

namespace App\Service\Files;

use App\Entity\File;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Provides File
 * service functionality
 * @package App\Service
 */
interface FilesServiceInterface {

	public function uploadFiles(int $appId,FileBag $files, string $group_hash):iterable;

	public function saveFiles(array $files):iterable;

	public function save(File $file):File;

	public function remove(File $file);

	public function uploadAndSaveFiles(int $appId,FileBag $files, string $group_hash):iterable;

	public function getById(int $id):?File;

	public function getByHash(string $hash):?File;

	public function getByAppId(int $id, int $page = 1, int $perpage = 10):iterable;

	public function getQueryByHash(int $id,string $hash, int $page = 1, int $perpage = 10):iterable;

	public function zipFiles(string $group_hash):string;

	public function getAll(int $page = 1, int $perpage = 10):iterable;

}
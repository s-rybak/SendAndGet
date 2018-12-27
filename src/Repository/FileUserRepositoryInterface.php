<?php

namespace App\Repository;
use App\Entity\FileUser;

/**
 * Interface FileUserRepositoryInterface
 *
 * File User manager
 *
 * @package App\Repository
 */
interface FileUserRepositoryInterface {

	public function save($user);

	public function saveMany(array $entities): array;

	public function remove($user):void;

	public function getById(int $id);

	public function getList(int $page, int $perpage = 10): iterable;

	public function getDownloaded(int $page, int $perpage = 10): iterable;

	public function getByFileID(int $id, int $page = 1, int $perpage = 10): iterable;

	public function getByUserID(int $id, int $page = 1, int $perpage = 10): iterable;

	public function getByFileAndUserId(int $file_id,int $user_id): ?FileUser;


}
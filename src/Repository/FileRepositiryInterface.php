<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/16/18
 * Time: 12:07 AM
 */

namespace App\Repository;


use App\Entity\File;

interface FileRepositiryInterface {

	public function save($file);

	public function saveMany(array $files):array;

	public function remove($file):void;

	public function getByHash(string $hash):?File;

	public function getById(int $id);

	public function getByAppId(int $id, int $page = 1, int $perpage = 10):iterable;

	public function getList(int $page, int $perpage = 10):iterable;

	public function getByGroupHash(string $group_hash):iterable;

	public function getQueryByHash(int $id,string $hash, int $page = 1, int $perpage = 10):iterable;

}
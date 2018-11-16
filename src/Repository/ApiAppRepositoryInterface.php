<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/14/18
 * Time: 9:18 PM
 */

namespace App\Repository;
use App\Entity\ApiApp;

/**
 * Provides App api db manage
 * functionality
 * @package App\Repository
 */
interface ApiAppRepositoryInterface {

	public function save($app);

	public function getById(int $id);

	public function getList(int $page, int $perpage = 10):iterable;

	public function getByKey(string $key):?ApiApp;

}
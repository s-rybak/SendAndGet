<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/16/18
 * Time: 12:07 AM
 */

namespace App\Repository;


interface FileRepositiryInterface {

	public function save($file);

	public function saveMany(array $files):array;

}
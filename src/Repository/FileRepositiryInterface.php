<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\File;

interface FileRepositiryInterface
{
    public function save($file);

	public function length():int;

    public function saveMany(array $files): array;

    public function remove($file): void;

    public function getByHash(string $hash): ?File;

    public function getById(int $id);

    public function getByAppId(int $id, int $page = 1, int $perpage = 10): iterable;

    public function getList(int $page, int $perpage = 10): iterable;

    public function getByGroupHash(string $group_hash): iterable;

    public function getQueryByHash(int $id, string $hash, int $page = 1, int $perpage = 10): iterable;

    public function getExpired(int $limit):iterable;

    public function getDeletedExpired(int $limit):iterable;

    public function expireAppFiles(int $appId):void;

    public function getFilesSize():int;

}

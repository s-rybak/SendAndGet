<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Files;

use App\DTO\FileBagSizeDTO;
use App\Entity\ApiApp;
use App\Entity\File;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Provides File
 * service functionality.
 */
interface FilesServiceInterface
{
    public function uploadFiles(int $appId, FileBag $files, string $group_hash, int $user_id): iterable;

    public function saveFiles(array $files): iterable;

    public function save(File $file): File;

    public function remove(File $file, $soft = true);

    public function uploadAndSaveFiles(int $appId, FileBag $files, string $group_hash,int $user_id): iterable;

    public function getById(int $id): ?File;

    public function getByHash(string $hash): ?File;

    public function getByGroupHash(string $hash): iterable;

    public function getByAppId(int $id, int $page = 1, int $perpage = 10): iterable;

    public function getByUserId(int $id, int $page = 1, int $perpage = 10): iterable;

    public function getQueryByHash(int $id, string $hash, int $page = 1, int $perpage = 10): iterable;

    public function zipFiles(string $group_hash): StreamedResponse;

    public function zipFilesPack(iterable $files, string $group_hash): StreamedResponse;

    public function getAll(int $page = 1, int $perpage = 10): iterable;

    public function prolong(File $file);

    public function expire(File $file);

    public function expireAppFiles(int $appId);

    public function getExpired(int $limit): iterable;

    public function getDeletedExpired(int $limit): iterable;

    public function getFileBagSize(FileBag $flies): FileBagSizeDTO;

    public function changeAppLimits(ApiApp $app, FileBag $flies): ApiApp;

	public function setStatusByUserId(int $id = 0, string $status): void;

	public function setStatusByUserIdPack( array $ids, string $status ): void;

}

<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Files;

use App\DTO\UploadedFileDTO;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * File uploader interface
 * Provides upload file functionality.
 */
interface FileUploaderInterface
{
    public function setAppId(int $app_id): void;

    public function setFileLifeTime(int $fileLifeTime): void;

    public function setGroupHash(string $group_hash): void;

    public function upload(UploadedFile $file): UploadedFileDTO;

    public function getTargetDirectory(): string;
}

<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Transformer;

use App\DTO\UploadedFileDTO;
use App\Entity\File;

class UploadedFileToFileTransformer
{
    public function getFile(UploadedFileDTO $file_DTO): File
    {
        $file = new File();
        $file->setName($file_DTO->getFileName());
        $file->setPath($file_DTO->getFilePath());
        $file->setType($file_DTO->getExt());
        $file->setAppId($file_DTO->getAppId());
        $file->setStatus($file_DTO->getStatus());
        $file->setGroupHash($file_DTO->getGroupHash());
        $file->setLifeTime($file_DTO->getFileLifeTime());
        $file->setSize($file_DTO->getSize());

        return $file;
    }
}

<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Files;

use App\Entity\ApiApp;
use App\Entity\File;
use App\DTO\FileBagSizeDTO;
use App\Exceptions\EntityNotFoundException;
use App\Repository\FileRepositiryInterface;
use App\Transformer\UploadedFileToFileTransformer;
use Symfony\Component\HttpFoundation\FileBag;

class FilesService implements FilesServiceInterface
{
    private $uploader;
    private $transformer;
    private $repositiry;
    private $uploadDir;
    private $fileLifeTime;

    public function __construct(
        FileUploaderInterface $file_uploader,
        UploadedFileToFileTransformer $transformer,
        FileRepositiryInterface $repositiry,
        $uploadDir,
        $fileLifeTime
    ) {
        $this->uploader = $file_uploader;
        $this->transformer = $transformer;
        $this->repositiry = $repositiry;
        $this->uploadDir = $uploadDir;
        $this->fileLifeTime = $fileLifeTime;
    }

    public function uploadFiles(int $appId, FileBag $files, string $group_hash): iterable
    {
        $filesArray = [];

        $this->uploader->setAppId($appId);
        $this->uploader->setGroupHash($group_hash);
        $this->uploader->setFileLifeTime($this->fileLifeTime);

        foreach ($files as $file) {
            $filesArray[] = $this->transformer->getFile(
                $this->uploader->upload($file)
            );
        }

        return $filesArray;
    }

    public function saveFiles(array $files): iterable
    {
        return $this->repositiry->saveMany($files);
    }

    public function uploadAndSaveFiles(int $appId, FileBag $files, string $group_hash): iterable
    {
        return $this->saveFiles(
            $this->uploadFiles($appId, $files, $group_hash)
        );
    }

    public function getById(int $id): ?File
    {
        return $this->repositiry->getById($id);
    }

    public function getByHash(string $hash): ?File
    {
        return $this->repositiry->getByHash($hash);
    }

    public function zipFiles(string $group_hash): string
    {
        $files = $this->repositiry->getByGroupHash($group_hash);

        if (null == $files && 0 === count($files)) {
            throw new EntityNotFoundException("Group $group_hash not found");
        }

        $zip = new \ZipArchive();
        $zipName = $this->uploadDir.$files[0]->getPath().'all.zip';
        $zip->open($zipName, \ZipArchive::CREATE);
        foreach ($files as $f) {
            $zip->addFromString($f->getName(), file_get_contents($this->uploadDir.$f->getPath().$f->getName()));
        }
        $zip->close();

        return $zipName;
    }

    public function getByAppId(int $id, int $page = 1, int $perpage = 10): iterable
    {
        return $this->repositiry->getByAppId($id, $page, $perpage);
    }

    public function getQueryByHash(int $id, string $hash, int $page = 1, int $perpage = 10): iterable
    {
        return $this->repositiry->getQueryByHash($id, $hash, $page, $perpage);
    }

    public function getAll(int $page = 1, int $perpage = 10): iterable
    {
        return $this->repositiry->getList($page, $perpage);
    }

    public function save(File $file): File
    {
        return $this->repositiry->save($file);
    }

    public function remove(File $file, $soft = true)
    {
        $this->repositiry->remove($file);

        if (!$soft) {
            $path = $this->uploadDir.$file->getPath().$file->getName();

            unlink($path);
        }
    }

    public function prolong(File $file)
    {
        $this->save(
            $file
                ->setAviableAt(new \DateTime())
                ->setDeletesIn(
                    new \DateTime("+{$file->getLifeTime()} day")
                )
        );
    }

    public function expire(File $file)
    {
        $this->save(
            $file
                ->setDeletesIn(new \DateTime())
        );
    }

    public function getExpired(int $limit): iterable
    {
        return $this->repositiry->getExpired($limit);
    }

    public function getDeletedExpired(int $limit): iterable
    {
        return $this->repositiry->getDeletedExpired($limit);
    }

    public function expireAppFiles(int $appId)
    {
        $this->repositiry->expireAppFiles($appId);
    }

    public function getFileBagSize(FileBag $flies): FileBagSizeDTO
    {
        $size = new FileBagSizeDTO();

        foreach ($flies as $file) {
            $size->countFile($file->getClientSize() / 1000000, $file->getClientOriginalName());
        }

        return $size;
    }

    public function changeAppLimits(ApiApp $app, FileBag $flies): ApiApp
    {
        $size = $this->getFileBagSize($flies);

        if ($app->getStorage() < $size->getSize()) {
            $sz = number_format($size->getSize(), 2);

            throw new \Exception("App storage exceeded ( You try to upload {$sz} Mb ). Storage left: {$app->getStorage()} Mb");
        }

        if ($app->getLimits() < $size->getMaxFileSize()) {
            $sz = number_format($size->getMaxFileSize(), 2);

            throw new \Exception("App max file ({$size->getMaxFileName()} : {$sz} Mb) size exceeded. Max size: {$app->getLimits()} Mb");
        }

        return $app->setStorage($app->getStorage() - $size->getSize());
    }
}

<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Exceptions\EntityNotFoundException;
use App\Service\Files\FilesServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * File site controller
 * get and serach files.
 *
 * @author Sergey R <qwe@qwe.com>
 */
class FileController extends AbstractController
{
    private $service;
    private $uploadDir;

    public function __construct(FilesServiceInterface $service, $uploadDir)
    {
        $this->service = $service;
        $this->uploadDir = $uploadDir;
    }

    public function getFileByHash(string $hash): Response
    {
        $file = $this->service->getByHash($hash);

        if (null == $file || 'deleted' === $file->getStatus()) {
            throw new NotFoundHttpException("File $hash not found");
        }

        if ('active' !== $file->getStatus()) {
            throw new NotFoundHttpException("File $hash was blocked for download");
        }

        return $this->file($this->uploadDir.$file->getPath().$file->getName());
    }

    public function getSiteFileByHash(string $hash): Response
    {
        $file = $this->service->getByHash($hash);

        if (null == $file || 'deleted' === $file->getStatus()) {
            throw new NotFoundHttpException("File $hash not found");
        }

        if ('site_file' !== $file->getStatus()) {
            throw new NotFoundHttpException("File $hash was blocked for download");
        }

        return $this->file($this->uploadDir.$file->getPath().$file->getName());
    }

    public function getAllFilesByHash(string $hash): Response
    {
        try {
            $zip = $this->service->zipFiles($hash);

            return $this->file($zip);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}

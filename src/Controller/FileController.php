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
use App\Service\User\FileUserServiceIntervface;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ZipStream\Exception;

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
    private $fileUserService;
    private $userService;

    public function __construct(FilesServiceInterface $service, $uploadDir, FileUserServiceIntervface $uservice,UserServiceInterface $userService)
    {
        $this->service = $service;
        $this->uploadDir = $uploadDir;
        $this->fileUserService = $uservice;
        $this->userService = $userService;
    }

    public function getFileByHash(string $hash,Request $request): Response
    {
        $file = $this->service->getByHash($hash);

        if (null == $file || 'deleted' === $file->getStatus()) {
            throw new NotFoundHttpException("File $hash not found");
        }

        if ('active' !== $file->getStatus()) {
            throw new NotFoundHttpException("File $hash was blocked for download");
        }

        $user = $this->userService->getCreateServiceUser($request);

	    if($user->getStatus() !== "active"){

		    throw new NotFoundHttpException("You blocked. Please contact site administrator");

	    }

	    $this->fileUserService->addDownload($user,$file);

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

    public function getAllFilesByHash(string $hash, Request $request): StreamedResponse
    {
        try {

	        $user = $this->userService->getCreateServiceUser($request);
	        $files = $files = $this->service->getByGroupHash($hash);

	        if($user->getStatus() !== "active"){

		        throw new NotFoundHttpException("You blocked. Please contact site administrator");

	        }

	        $this->fileUserService->addDownloadMany($user,$files);

            return $this->service->zipFilesPack($files,$hash);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}

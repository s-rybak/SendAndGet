<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api;

use App\Resource\ApiErrorResponceResource;
use App\Resource\ApiSuccessResponceResource;
use App\Service\AppApiServiceInterface;
use App\Service\Files\FilesServiceInterface;
use App\Service\User\UserServiceInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Files api controller.
 */
final class FilesController extends FOSRestController
{
    private $appApi;
    private $fileService;
    private $appService;
    private $userService;

    public function __construct(
        TokenStorageInterface $token,
        FilesServiceInterface $service,
        AppApiServiceInterface $appService,
        UserServiceInterface $userService
    ) {
        $this->appApi = $token->getToken()->getUser();
        $this->fileService = $service;
        $this->appService = $appService;
        $this->userService = $userService;
    }

    /**
     * Get Files list.
     *
     * @return View
     *
     * @Rest\Get("/files/list")
     */
    public function getAppFilesList(Request $request): View
    {
        $page = $request->get('page');

        return $this->view(
            new ApiSuccessResponceResource(
                $this->fileService->getByAppId(
                    $this->appApi->getId(),
                    $page ? $page : 1
                )
            ),
            Response::HTTP_OK);
    }

    /**
     * Get Files list.
     *
     * @return View
     *
     * @Rest\Get("/files/query")
     */
    public function getQueryAppFiles(Request $request): View
    {
        $hash = $request->get('hash');
        $page = $request->get('page');

        if (null == $hash) {
            return $this->view(
                new ApiErrorResponceResource('hash parameter is required'),
                Response::HTTP_BAD_REQUEST);
        }

        return $this->view(
            new ApiSuccessResponceResource(
                $this->fileService->getQueryByHash(
                    $this->appApi->getId(),
                    $hash,
                    $page ? $page : 1
                )
            ),
            Response::HTTP_OK);
    }

    /**
     * Get Files list.
     *
     * @param Request $request
     *
     * @return View
     *
     * @Rest\Post("/files/upload")
     */
    public function postFilesUpload(Request $request): View
    {
        $filesCount = count($request->files);

        if ($filesCount <= 0) {
            return $this->view(
                new ApiErrorResponceResource('No files to upload'),
                Response::HTTP_BAD_REQUEST);
        }

        if ($filesCount > 1000) {
            return $this->view(
                new ApiErrorResponceResource('Max file size exceded (max files 1000 at once)'),
                Response::HTTP_BAD_REQUEST);
        }

        try {
            $hash = $request->get('groupHash');
            $hash = $hash ? $hash : uniqid();

            $this->appService->save(
                $this
                ->fileService
                ->changeAppLimits($this->appApi, $request->files)
            );

            $user = $this->userService->getCreateServiceUser($request);

            if ('active' !== $user->getStatus()) {
                throw new \Exception('You blocked. Please contact site administrator');
            }

            $files = $this->fileService->uploadAndSaveFiles($this->appApi->getId(), $request->files, $hash, $user->getId());
        } catch (\Exception $e) {
            return $this->view(
                new ApiErrorResponceResource($e->getMessage()),
                Response::HTTP_BAD_REQUEST);
        }

        return $this->view(
            new ApiSuccessResponceResource($files),
            Response::HTTP_CREATED, ['Access-Control-Allow-Origin' => $this->appApi->getHost()]
        );
    }

    /**
     * Delete Files list.
     *
     * @param Request $request
     *
     * @return View
     *
     * @Rest\Delete("/files/delete")
     */
    public function deleteFile(Request $request): View
    {
        $hash = $request->get('hash');

        if (null == $hash) {
            return $this->view(
                new ApiErrorResponceResource('hash parameter is required'),
                Response::HTTP_BAD_REQUEST);
        }

        $file = $this->fileService->getByHash($hash);

        if (null === $file) {
            return $this->view(
                new ApiErrorResponceResource("File $hash not found"),
                Response::HTTP_BAD_REQUEST);
        }

        $this->fileService->save(
            $file->setStatus('deleted')
        );

        return $this->view(
            new ApiSuccessResponceResource('', 'success'),
            Response::HTTP_ACCEPTED, ['Access-Control-Allow-Origin' => $this->appApi->getHost()]
        );
    }
}

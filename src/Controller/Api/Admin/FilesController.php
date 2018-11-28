<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api\Admin;

use App\Resource\ApiErrorResponceResource;
use App\Resource\ApiSuccessResponceResource;
use App\Service\Files\FilesServiceInterface;
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

	public function __construct(TokenStorageInterface $token, FilesServiceInterface $service)
	{
		$this->appApi = $token->getToken()->getUser();
		$this->fileService = $service;
	}

	/**
	 * Delete Files list.
	 *
	 * @param Request $request
	 *
	 * @return View
	 *
	 * @Rest\Delete("admin/files/delete")
	 */
	public function deleteFile(Request $request): View
	{
		$id = $request->get('id');

		if (null == $id) {
			return $this->view(
				new ApiErrorResponceResource('id parameter is required'),
				Response::HTTP_BAD_REQUEST);
		}

		$file = $this->fileService->getById($id);

		if (null === $file) {
			return $this->view(
				new ApiErrorResponceResource("File $id not found"),
				Response::HTTP_BAD_REQUEST);
		}

		$this->fileService->remove($file);

		return $this->view(
			new ApiSuccessResponceResource('', 'success'),
			Response::HTTP_ACCEPTED, ['Access-Control-Allow-Origin' => $this->appApi->getHost()]
		);
	}

}

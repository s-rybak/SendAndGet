<?php

namespace App\Controller\Api;


use App\Service\Files\FilesServiceInterface;
use App\Service\Files\FileUploaderInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Files api controller
 * @package App\Controller\Api
 */

final class FilesController extends FOSRestController {

	private $appApi;

	public function __construct(TokenStorageInterface $token) {

		$this->appApi = $token->getToken()->getUser();

	}

	/**
	 * Get Files list
	 *
	 * @return View
	 *
	 * @Rest\Get("/files/list")
	 */
	public function getFilesList(FileUploaderInterface $file_uploader): View
	{
		return $this->view(['test'=>1,'user'=>$this->appApi,'path'=>$file_uploader->getTargetDirectory()], Response::HTTP_OK);
	}

	/**
	 * Get Files list
	 *
	 * @param Request $request
	 *
	 * @return View
	 *
	 * @Rest\Post("/files/upload")
	 */
	public function postFilesUpload(FilesServiceInterface $service, Request $request): View
	{

		$filesCount = count($request->files);

		if($filesCount <= 0){

			return $this->view([
				'error'=>"No files"
			], Response::HTTP_OK);

		}

		if($filesCount > 10){

			return $this->view([
				'error'=>"Max files exceded"
			], Response::HTTP_OK);

		}

		try{
			$files = $service->uploadAndSaveFiles($this->appApi->getId(),$request->files);

		}catch (\Exception $e){
			return $this->view([
				'error'=>$e->getMessage()
			], Response::HTTP_OK);
		}


		return $this->view([
			'files'=>$files
		], Response::HTTP_OK);
	}

}
<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/16/18
 * Time: 12:31 AM
 */

namespace App\Controller;

use App\Service\AppApiServiceInterface;
use App\Service\JsSdkServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JsSdkController extends AbstractController {

	public function jsSdk(
		Request $request,
		AppApiServiceInterface $service,
		JsSdkServiceInterface $sdk_service
	): Response
	{

		$key = $request->get('key');

		if(null !== $key && $service->checkApiKey($key)){

			$rendered = $this->renderView( 'js_sdk/js_sdk.js.twig', [
				'app'=>$sdk_service->getJsSdkDto($key)
			] );
			$response = new Response( $rendered );
			$response->headers->set( 'Content-Type', 'text/javascript' );
			return $response;

		}

		throw new NotFoundHttpException("Api key is not valid");

	}


}
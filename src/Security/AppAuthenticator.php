<?php

namespace App\Security;

use App\Service\AppApiServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AppAuthenticator extends AbstractGuardAuthenticator {
	private $appApiService;

	public function __construct( AppApiServiceInterface $appApiService ) {
		$this->appApiService = $appApiService;
	}

	/**
	 * Called on every request to decide if this authenticator should be
	 * used for the request. Returning false will cause this authenticator
	 * to be skipped.
	 */
	public function supports( Request $request ) {
		return $request->headers->has( 'X-API-KEY' ) && $request->headers->has( 'Origin' );
	}

	/**
	 * Called on every request. Return whatever credentials you want to
	 * be passed to getUser() as $credentials.
	 */
	public function getCredentials( Request $request ) {
		return array(
			'key'    => $request->headers->get( 'X-API-KEY' ),
			'host' => $request->headers->get( 'Host' ),
		);
	}

	public function getUser( $credentials, UserProviderInterface $userProvider ) {

		$apiKey = $credentials['key'];

		if ( null === $apiKey || null === $credentials['host'] ) {
			return;
		}

		return $this->appApiService->getByKey($apiKey);
	}

	public function checkCredentials( $credentials, UserInterface $user ) {
		return strpos( strtolower( $user->getHost() ), strtolower( $credentials['host'] ) ) === 0 &&
		       $this->appApiService->checkAppApiKey($credentials['key'],$user);
	}

	public function onAuthenticationSuccess( Request $request, TokenInterface $token, $providerKey ) {
		return null;
	}

	public function onAuthenticationFailure( Request $request, AuthenticationException $exception ) {

		$msg = $exception->getMessageKey();

		if ( $msg == "Username could not be found." ) {

			$msg = "Api key not registered";

		}

		$data = array(
			'message' => strtr( $msg, $exception->getMessageData() )
		);

		return new JsonResponse( $data, Response::HTTP_FORBIDDEN );
	}

	/**
	 * Called when authentication is needed, but it's not sent
	 */
	public function start( Request $request, AuthenticationException $authException = null ) {
		$data = array(
			'message' => 'Authentication Required'
		);

		return new JsonResponse( $data, Response::HTTP_UNAUTHORIZED );
	}

	public function supportsRememberMe() {
		return false;
	}
}
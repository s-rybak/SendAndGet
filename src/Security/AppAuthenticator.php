<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

class AppAuthenticator extends AbstractGuardAuthenticator
{
    private $appApiService;

    public function __construct(AppApiServiceInterface $appApiService)
    {
        $this->appApiService = $appApiService;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning false will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {
        return $request->headers->has('X-API-KEY') && $request->headers->has('Host');
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request)
    {
        return [
            'key' => $request->headers->get('X-API-KEY'),
            'host' => $request->headers->get('Host'),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $apiKey = $credentials['key'];

        if (null === $apiKey || null === $credentials['host']) {
            return;
        }

        return $this->appApiService->getByKey($apiKey);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return 0 === strpos(strtolower($user->getHost()), strtolower($credentials['host'])) &&
               $this->appApiService->checkAppApiKey($credentials['key'], $user);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $msg = $exception->getMessageKey();

        if ('Username could not be found.' == $msg) {
            $msg = 'Api key not registered';
        }

        $data = [
            'message' => strtr($msg, $exception->getMessageData()),
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent.
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'message' => 'Authentication Required',
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}

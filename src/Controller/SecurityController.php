<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * App security controller.
 */
final class SecurityController extends AbstractController
{
    /**
     * Login page.
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error = $authenticationUtils->getLastAuthenticationError()) {
            $this->addFlash('danger', $error->getMessage());
        }

        return $this->render('security/login.html.twig', \compact('lastUsername'));
    }

    /**
     * Logout action.
     */
    public function logout(): void
    {
    }
}

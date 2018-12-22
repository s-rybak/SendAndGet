<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Builder\AdminPageBuilderInterface;
use App\Entity\ApiApp;
use App\Form\ApiAppType;
use App\Service\Admin\AdminEntityServiceInterface;
use App\Service\AppApiServiceInterface;
use App\Service\Files\FilesServiceInterface;
use App\Service\User\UserServiceInterface;
use FOS\RestBundle\Tests\Fixtures\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Admin site pages
 * controller.
 */
class UsersController extends AbstractController
{
    private $pageService;
    private $userService;

    public function __construct(
        AdminPageBuilderInterface $pageService,
		UserServiceInterface $userService
    ) {
        $this->pageService = $pageService;
        $this->userService = $userService;
    }

    /**
     * admin api apps page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function users(int $page, string $status): Response
    {

    	if($status === "all"){

		    $users = $this->userService->getAll($page, 10);

	    }else{

		    $users = $this->userService->getByStatus($status, $page, 10);

	    }

        return $this->render('admin/users.html.twig', [
            'page' => $this->pageService->getUsersResource(),
            'users' => $users,
            'currentPage' => $page,
        ]);
    }


}

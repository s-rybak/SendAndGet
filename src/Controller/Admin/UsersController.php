<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Builder\AdminPageBuilderInterface;
use App\Entity\User;
use App\Form\UserType;
use App\Service\Files\FilesServiceInterface;
use App\Service\User\FileUserServiceIntervface;
use App\Service\User\UserServiceInterface;
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
    private $filesService;
    private $fileUserService;

    public function __construct(
        AdminPageBuilderInterface $pageService,
		UserServiceInterface $userService,
		FilesServiceInterface $filesService,
		FileUserServiceIntervface $fileUserService
    ) {
        $this->pageService = $pageService;
        $this->userService = $userService;
        $this->filesService = $filesService;
        $this->fileUserService = $fileUserService;
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

	/**
	 * admin edit user.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function editUser(int $id, int $page): Response
	{
		$user = $this->userService->getById($id);

		if (null === $user) {
			throw new NotFoundHttpException("User with is $id not found");
		}

		$form = $this->createForm(UserType::class, $user);

		return $this->render('admin/edit_user.html.twig', [
			'page' => $this->pageService->getEditUserResource("User #$id"),
			'form' => $form->createView(),
			'user' => $user,
			'files' => $this->filesService->getByUserId($id,$page),
			'downloads' => $this->fileUserService->getByUserId($id,$page),
			'currentPage' => $page,
		]);
	}

	/**
	 * admin save user.
	 *
	 * @param int $id
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function store(int $id, Request $request): Response
	{
		$user = 0 !== $id ? $this->userService->getById($id) : new User();

		if (null === $user) {
			throw new NotFoundHttpException("User with is $id not found");
		}

		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$user = $this->userService->save($form->getData());
		}

		return $this->redirectToRoute('admin_users_edit', ['id' => $user->getId()], 301);
	}

	/**
	 * admin change user status.
	 *
	 * @param int     $id
	 * @param string  $status
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function changeStatus(int $id, string $status, Request $request): Response
	{
		$user = $this->userService->getById($id);

		if (null === $user) {
			throw new NotFoundHttpException("App with is $id not found");
		}

		$this->userService->save(
			$user->setStatus($status)
		);

		return $this->redirect(
			$request->headers->get('referer')
		);
	}

	/**
	 * admin change user status.
	 *
	 * @param string     $ip
	 * @param string  $status
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function changeStatusByIp(string $ip, string $status, Request $request): Response
	{

		$this->userService->setStatusByIp($ip,$status);

		return $this->redirect(
			$request->headers->get('referer')
		);
	}

	/**
	 * admin change user files status.
	 *
	 * @param int     $id
	 * @param string  $status
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function changeFileStatus(int $id, string $status, Request $request): Response
	{

		$this->filesService->setStatusByUserId($id,$status);

		return $this->redirect(
			$request->headers->get('referer')
		);
	}

	/**
	 * admin change user status.
	 *
	 * @param string     $ip
	 * @param string  $status
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function changeFileStatusByIp(string $ip, string $status, Request $request): Response
	{

		$users = $this->userService->getByIp($ip,1,999999999);

		if(count($users) > 0){

			$ips = [];

			foreach ($users as $ip){

				$ips[] = $ip->getId();

			}

			$this->filesService->setStatusByUserIdPack($ips,$status);

		}


		return $this->redirect(
			$request->headers->get('referer')
		);
	}

	/**
	 * admin change expire files by user.
	 *
	 * @param int  $id
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function expireFileByUID(int $id, Request $request): Response
	{

		$this->filesService->expireByUser($id);

		return $this->redirect(
			$request->headers->get('referer')
		);
	}

	/**
	 * admin change expire files by user ip.
	 *
	 * @param string  $ip
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function expireFileByIp(string $ip, Request $request): Response
	{

		$users = $this->userService->getByIp($ip,1,999999999);

		if(count($users) > 0){

			$ips = [];

			foreach ($users as $ip){

				$ips[] = $ip->getId();

			}

			$this->filesService->expireByUserIds($ips);

		}


		return $this->redirect(
			$request->headers->get('referer')
		);

	}

	/**
	 * admin delete all user data.
	 *
	 * @param int  $id
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function delete(int $id, Request $request): Response
	{

		$page = 1;

		while($files = $this->filesService->getByUserId($id,$page,100000)){

			$this->filesService->removeMany($files,false);
			$page++;

		};

		$user = $this->userService->getById($id);

		if(null !== $user){

			$this->userService->remove($user);

		}

		return $this->redirectToRoute('admin_users');
	}

	/**
	 * admin delete all user data by ip.
	 *
	 * @param string  $ip
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function deleteByIp(string $ip, Request $request): Response
	{

		$page = 1;

		while ($users = $this->userService->getByIp($ip,$page,100000)){

			foreach ($users as $user){

				$fp = 1;

				while($files = $this->filesService->getByUserId($user->getId(),$fp,100000)){

					$this->filesService->removeMany($files,false);
					$fp++;

				};

				$this->userService->remove($user);

			}

			$page++;

		}

		return $this->redirectToRoute('admin_users');
	}

	/**
	 * admin all downloads
	 *
	 * @param int  $page
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function downloads(int $page): Response
	{

		return $this->render('admin/downloads.html.twig', [
			'page' => $this->pageService->getDownloadsResource(),
			'downloads' => $this->userService->getDownloads($page),
			'currentPage' => $page,
		]);

	}

}

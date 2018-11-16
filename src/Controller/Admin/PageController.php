<?php

namespace App\Controller\Admin;

use App\Builder\AdminPageBuilderInterface;
use App\Service\Admin\AdminEntityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Admin site pages
 * controller
 *
 * @package App\Controller\Admin
 */

class PageController extends AbstractController{

	private $pageBuilder;
	private $entitysService;

	public function __construct(
		AdminPageBuilderInterface $pageBuilder,
		AdminEntityServiceInterface $entitysService
	) {
		$this->pageBuilder = $pageBuilder;
		$this->entitysService = $entitysService;
	}
	/**
	 * admin pages page.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function pages(): Response
	{
		return $this->render('admin/pages.html.twig', [
			'page' => $this->pageBuilder->getPagesResource(),
			'pages' => $this->entitysService->getPages(1, 10),
		]);
	}

	/**
	 * admin edit page page.
	 *
	 * @param int $id
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 *
	 * @throws NotFoundHttpException if page not found
	 */
	public function editPage(int $id, string $lang): Response
	{
		$page = $this->entitysService->getPageById($id);

		if (null === $page) {

			throw new NotFoundHttpException("Page with $id not found");
		}

		$page->setCurrentLocale($lang);

		return $this->render('admin/edit_page.html.twig', [
			'page' => $this->pageBuilder->getEditPageResource($page->getTitle()),
			'pageData' => $page,
		]);
	}

}
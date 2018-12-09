<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Builder\AdminPageBuilderInterface;
use App\Entity\Page;
use App\Entity\PageTranslation;
use App\Form\PageType;
use App\Service\Admin\AdminEntityServiceInterface;
use App\Service\Files\FilesServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Admin site pages
 * controller.
 */
class PageController extends AbstractController
{
    private $pageBuilder;
    private $entitysService;
    private $filesService;

    public function __construct(
        AdminPageBuilderInterface $pageBuilder,
        AdminEntityServiceInterface $entitysService,
        FilesServiceInterface $filesService
    ) {
        $this->pageBuilder = $pageBuilder;
        $this->entitysService = $entitysService;
        $this->filesService = $filesService;
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
        $pageTrans = $this->entitysService->getTranslationByPageId($id, $lang);

        if (null === $page) {
            throw new NotFoundHttpException("Page with $id not found");
        }

        $form = $this->createForm(PageType::class, $pageTrans);

        $page->setCurrentLocale($lang);

        return $this->render('admin/edit_page.html.twig', [
            'page' => $this->pageBuilder->getEditPageResource($page->getTitle()),
            'pageData' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * admin save page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(int $id, string $lang, Request $request): Response
    {
        $page = 0 !== $id ? $this->entitysService->getTranslationByPageId($id, $lang) : new PageTranslation();

        if (null === $page) {
            throw new NotFoundHttpException("Page with is $id not found");
        }

        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entitysService->saveTranslation($form->getData());
        }

        return $this->redirectToRoute('admin_edit_page', ['id' => $id, 'lang' => $lang], 301);
    }

    /**
     * admin add image to page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addImage(Request $request): Response
    {
        $image = $request->get('image');
        $id = $request->get('id');

        $page = $this->entitysService->getPageById($id);
        $image = $this->filesService->getByHash($image);

        if (null === $page) {
            throw new NotFoundHttpException("Page with id $id not found");
        }

        if (null === $image) {
            throw new NotFoundHttpException("Image with hash $image not found");
        }

        $image->setStatus('site_file');
        $page->setImage('/s/'.$image->getHash());

        $this->entitysService->savePage($page);
        $this->filesService->save($image);

        return $this->json(['status' => 'success']);
    }
}

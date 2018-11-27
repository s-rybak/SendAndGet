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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Admin site pages
 * controller.
 */
class AppController extends AbstractController
{
    private $pageService;
    private $entitysService;
    private $appApiService;

    public function __construct(
        AdminPageBuilderInterface $pageService,
        AdminEntityServiceInterface $entitysService,
        AppApiServiceInterface $appApiService
    ) {
        $this->pageService = $pageService;
        $this->entitysService = $entitysService;
        $this->appApiService = $appApiService;
    }

    /**
     * admin api apps page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apps(int $page): Response
    {
        $apps = $this->appApiService->getList($page, 10);

        return $this->render('admin/apps.html.twig', [
            'page' => $this->pageService->getAppApiResource(),
            'apps' => $apps,
        ]);
    }

    /**
     * admin edit apps page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editApp(int $id): Response
    {
        $app = $this->appApiService->getById($id);

        if (null === $app) {
            throw new NotFoundHttpException("App with is $id not found");
        }

        $form = $this->createForm(ApiAppType::class, $app);

        return $this->render('admin/edit_app.html.twig', [
            'page' => $this->pageService->getEditAppApiResource("App #$id"),
            'form' => $form->createView(),
            'app' => $app,
        ]);
    }

    /**
     * admin add apps page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addApp(): Response
    {
        $app = new ApiApp();
        $form = $this->createForm(ApiAppType::class, $app);

        return $this->render('admin/edit_app.html.twig', [
            'page' => $this->pageService->getEditAppApiResource('Add new app'),
            'form' => $form->createView(),
            'app' => $app,
        ]);
    }

    /**
     * admin save app.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(int $id, Request $request): Response
    {
        $app = 0 !== $id ? $this->appApiService->getById($id) : new ApiApp();

        if (null === $app) {
            throw new NotFoundHttpException("App with is $id not found");
        }

        $form = $this->createForm(ApiAppType::class, $app);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $app = $this->appApiService->save($form->getData());
        }

        return $this->redirectToRoute('admin_edit_app', ['id' => $app->getId()], 301);
    }
}

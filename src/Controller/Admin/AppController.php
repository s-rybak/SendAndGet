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
    private $fileService;

    public function __construct(
        AdminPageBuilderInterface $pageService,
        AdminEntityServiceInterface $entitysService,
        AppApiServiceInterface $appApiService,
        FilesServiceInterface $fileService
    ) {
        $this->pageService = $pageService;
        $this->entitysService = $entitysService;
        $this->appApiService = $appApiService;
        $this->fileService = $fileService;
    }

    /**
     * admin api apps page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apps(int $page, string $status): Response
    {
        $apps = $this->appApiService->getByStatus($status, $page, 10);

        return $this->render('admin/apps.html.twig', [
            'page' => $this->pageService->getAppApiResource(),
            'apps' => $apps,
            'currentPage' => $page,
        ]);
    }

    /**
     * admin edit apps page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editApp(int $id, int $page): Response
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
            'files' => $this->fileService->getByAppId($id, $page),
            'currentPage' => $page,
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

    /**
     * admin change app status.
     *
     * @param int     $id
     * @param string  $status
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changeStatus(int $id, string $status, Request $request): Response
    {
        $app = $this->appApiService->getById($id);

        if (null === $app) {
            throw new NotFoundHttpException("App with is $id not found");
        }

        $this->appApiService->save(
            $app->setStatus($status)
        );

        return $this->redirect(
            $request->headers->get('referer')
        );
    }

    /**
     * admin remove app.
     *
     * @param int     $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function remove(int $id, Request $request): Response
    {
        $app = $this->appApiService->getById($id);

        if (null === $app) {
            throw new NotFoundHttpException("App with is $id not found");
        }

        $this->appApiService->remove($app);

        return $this->redirectToRoute('admin_apps');
    }

    /**
     * admin clear app storage.
     * Set App files expired.
     *
     * @param int     $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function clearStorage(int $id, Request $request): Response
    {
        $app = $this->appApiService->getById($id);

        if (null === $app) {
            throw new NotFoundHttpException("App with is $id not found");
        }

        $this->fileService->expireAppFiles($id);

        return $this->redirect(
            $request->headers->get('referer')
        );
    }

    /**
     * admin regenerate app keys.
     *
     * @param int     $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function regenerateKeys(int $id, Request $request): Response
    {
        $app = $this->appApiService->getById($id);

        if (null === $app) {
            throw new NotFoundHttpException("App with is $id not found");
        }

        $this->appApiService->save(
            $this->appApiService->generateKeys($app)
        );

        return $this->redirect(
            $request->headers->get('referer')
        );
    }
}

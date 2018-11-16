<?php

namespace App\Controller;

use App\Builder\AdminPageBuilderInterface;
use App\Service\Admin\AdminEntityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Admin site controller
 * controller for site main pages.
 *
 * @author Sergey R <qwe@qwe.com>
 */
class AdminController extends AbstractController
{
    private $pageService;
    private $entitysService;

    public function __construct(
	    AdminPageBuilderInterface $pageService,
        AdminEntityServiceInterface $entitysService
    ) {
        $this->pageService = $pageService;
        $this->entitysService = $entitysService;
    }

    /**
     * dashboard page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'page' => new class() {
                public $title = 'Dashboard';
                public $description = 'site dashboard';
            },
            'breadcrumbs' => [
                new class() {
                    public $link = '/admin';
                    public $title = 'Dashboard';
                },
            ],
        ]);
    }

    /**
     * admin files page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function files(): Response
    {
        return $this->render('admin/files.html.twig', [
            'page' => new class() {
                public $title = 'Files';
                public $description = 'site dashboard';
            },
            'breadcrumbs' => [
                new class() {
                    public $link = '/admin';
                    public $title = 'Dashboard';
                },
            ],
        ]);
    }

    /**
     * admin edit file page.
     *
     * @param int $id
     *
     * @return Response
     */
    public function editFile(int $id): Response
    {
        return $this->render('admin/edit_file.html.twig', [
            'page' => new class() {
                public $title = 'File';
                public $description = 'site dashboard';
            },
            'breadcrumbs' => [
                new class() {
                    public $link = '/admin';
                    public $title = 'Dashboard';
                },

                new class() {
                    public $link = '/admin/files';
                    public $title = 'Files';
                },
            ],
        ]);
    }

    /**
     * admin reports page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reports(): Response
    {
        return $this->render('admin/reports.html.twig', [
            'page' => new class() {
                public $title = 'Reports';
                public $description = 'site dashboard';
            },
            'breadcrumbs' => [
                new class() {
                    public $link = '/admin';
                    public $title = 'Dashboard';
                },
            ],
        ]);
    }

    /**
     * admin  edit report page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editReports(int $id): Response
    {
        return $this->render('admin/edit_report.html.twig', [
            'page' => new class() {
                public $title = 'Reports';
                public $description = 'site dashboard';
            },
            'breadcrumbs' => [
                new class() {
                    public $link = '/admin';
                    public $title = 'Dashboard';
                },
            ],
        ]);
    }

    /**
     * admin languages page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function languages(): Response
    {
        return $this->render('admin/languages.html.twig', [
            'page' => new class() {
                public $title = 'Reports';
                public $description = 'site dashboard';
            },
            'breadcrumbs' => [
                new class() {
                    public $link = '/admin';
                    public $title = 'Dashboard';
                },
            ],
        ]);
    }

    /**
     * admin edit translation page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editTranslation(): Response
    {
        return $this->render('admin/edit_translation.html.twig', [
            'page' => new class() {
                public $title = 'Reports';
                public $description = 'site dashboard';
            },
            'breadcrumbs' => [
                new class() {
                    public $link = '/admin';
                    public $title = 'Dashboard';
                },
            ],
        ]);
    }

    /**
     * admin config page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function config(): Response
    {
        return $this->render('admin/config.html.twig', [
            'page' => new class() {
                public $title = 'Reports';
                public $description = 'site dashboard';
            },
            'breadcrumbs' => [
                new class() {
                    public $link = '/admin';
                    public $title = 'Dashboard';
                },
            ],
        ]);
    }
}

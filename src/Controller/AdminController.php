<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Builder\AdminPageBuilderInterface;
use App\Service\Admin\AdminEntityServiceInterface;
use App\Service\SiteStatisticServiceIntervace;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

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
    private $statisticService;

    public function __construct(
        AdminPageBuilderInterface $pageService,
        AdminEntityServiceInterface $entitysService,
	    SiteStatisticServiceIntervace $statisticServiceIntervace
    ) {
        $this->pageService = $pageService;
        $this->entitysService = $entitysService;
        $this->statisticService = $statisticServiceIntervace;
    }

    /**
     * dashboard page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'page' => $this->pageService->getDashboard(),
	        'stat' => $this->statisticService->getDashboardStatistic()
        ]);
    }

//
//    /**
//     * admin reports page.
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function reports(): Response
//    {
//        return $this->render('admin/reports.html.twig', [
//            'page' => new class() {
//                public $title = 'Reports';
//                public $description = 'site dashboard';
//            },
//            'breadcrumbs' => [
//                new class() {
//                    public $link = '/admin';
//                    public $title = 'Dashboard';
//                },
//            ],
//        ]);
//    }
//
//    /**
//     * admin  edit report page.
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function editReports(int $id): Response
//    {
//        return $this->render('admin/edit_report.html.twig', [
//            'page' => new class() {
//                public $title = 'Reports';
//                public $description = 'site dashboard';
//            },
//            'breadcrumbs' => [
//                new class() {
//                    public $link = '/admin';
//                    public $title = 'Dashboard';
//                },
//            ],
//        ]);
//    }
//
//    /**
//     * admin languages page.
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function languages(): Response
//    {
//        return $this->render('admin/languages.html.twig', [
//            'page' => new class() {
//                public $title = 'Reports';
//                public $description = 'site dashboard';
//            },
//            'breadcrumbs' => [
//                new class() {
//                    public $link = '/admin';
//                    public $title = 'Dashboard';
//                },
//            ],
//        ]);
//    }
//
//    /**
//     * admin edit translation page.
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function editTranslation(): Response
//    {
//        return $this->render('admin/edit_translation.html.twig', [
//            'page' => new class() {
//                public $title = 'Reports';
//                public $description = 'site dashboard';
//            },
//            'breadcrumbs' => [
//                new class() {
//                    public $link = '/admin';
//                    public $title = 'Dashboard';
//                },
//            ],
//        ]);
//    }
//
//    /**
//     * admin config page.
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function config(): Response
//    {
//        return $this->render('admin/config.html.twig', [
//            'page' => new class() {
//                public $title = 'Reports';
//                public $description = 'site dashboard';
//            },
//            'breadcrumbs' => [
//                new class() {
//                    public $link = '/admin';
//                    public $title = 'Dashboard';
//                },
//            ],
//        ]);
//    }
}

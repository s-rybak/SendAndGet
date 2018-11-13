<?php

namespace App\Controller;

use App\Service\EntityNotFoundException;
use App\Service\MainPageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Main site controller
 * controller for site main pages.
 *
 * @author Sergey R <qwe@qwe.com>
 */
class MainController extends AbstractController
{
    private $service;

    public function __construct(MainPageServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Index page.
     *
     * @param MainPageServiceInterface $service
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {
        try {
            return $this->render('main/index.html.twig');
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function aboutAs(): Response
    {
        try {
            return $this->render('main/page.html.twig', [
                'page' => $this->service->getAboutUs(),
            ]);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function contuctAs(): Response
    {
        try {
            return $this->render('main/page.html.twig', [
                'page' => $this->service->getContuctAs(),
            ]);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function tos(): Response
    {
        try {
            return $this->render("main\page.html.twig", [
                'page' => $this->service->getTOS(),
            ]);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function statistic(): Response
    {
        try {
            return $this->render('main/page.html.twig', [
                'page' => $this->service->getStatistic(),
            ]);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function api(): Response
    {
        try {
            return $this->render('main/page.html.twig', [
                'page' => $this->service->getAPI(),
            ]);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function faq(): Response
    {
        try {
            return $this->render('main/page.html.twig', [
                'page' => $this->service->getFAQ(),
            ]);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}

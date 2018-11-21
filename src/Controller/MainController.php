<?php

namespace App\Controller;

use App\Exceptions\EntityNotFoundException;
use App\Service\MainPageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
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
	    return $this->render('main/index.html.twig');
    }

    public function aboutAs(): Response
    {
        try {
            return $this->render('main/page.html.twig', [
                'page' => $this->service->getAboutUs(
	                $this->service->getCurrentLocale()
                ),
            ]);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function contuctAs(): Response
    {
        try {
            return $this->render('main/page.html.twig', [
                'page' => $this->service->getContuctAs(
	                $this->service->getCurrentLocale()
                ),
            ]);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function tos(): Response
    {
        try {
            return $this->render("main\page.html.twig", [
                'page' => $this->service->getTOS(
	                $this->service->getCurrentLocale()
                ),
            ]);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function statistic(): Response
    {
        try {
            return $this->render('main/page.html.twig', [
                'page' => $this->service->getStatistic(
	                $this->service->getCurrentLocale()
                ),
            ]);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function api(): Response
    {
        try {
            return $this->render('main/page.html.twig', [
                'page' => $this->service->getAPI(
	                $this->service->getCurrentLocale()
                ),
            ]);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function faq(): Response
    {
        try {
            return $this->render('main/page.html.twig', [
                'page' => $this->service->getFAQ(
	                $this->service->getCurrentLocale()
                ),
            ]);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function setLocale($locale){

	    $this->service->setCurrentLocale($locale);

	    return $this->redirectToRoute('index');

    }
}

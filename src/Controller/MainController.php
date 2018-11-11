<?php

namespace App\Controller;

use App\Service\MainPageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Main site controller
 * controller for site main pages
 *
 * @author Sergey R <qwe@qwe.com>
 * @package App\Controller
 */
class MainController extends AbstractController
{

	private $service;

	public function __construct(MainPageServiceInterface $service) {

		$this->service = $service;
	}

	/**
	 * Index page
	 * @param MainPageServiceInterface $service
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index(): Response
	{

		return $this->render("main\index.html.twig");

	}

	public function aboutAs(): Response
	{

		return $this->render("main\page.html.twig",[
			'page'=>$this->service->getAboutUs(),
		]);

	}

	public function contuctAs(): Response
	{

		return $this->render("main\page.html.twig",[
			'page'=>$this->service->getContuctAs(),
		]);

	}

	public function tos(): Response
	{

		return $this->render("main\page.html.twig",[
			'page'=>$this->service->getTOS(),
		]);

	}

	public function statistic(): Response
	{

		return $this->render("main\page.html.twig",[
			'page'=>$this->service->getStatistic(),
		]);

	}

	public function api(): Response
	{

		return $this->render("main\page.html.twig",[
			'page'=>$this->service->getAPI(),
		]);

	}

	public function faq(): Response
	{

		return $this->render("main\page.html.twig",[
			'page'=>$this->service->getFAQ(),
		]);

	}

}
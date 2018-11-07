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

	/**
	 * Index page
	 * @param MainPageServiceInterface $service
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index(MainPageServiceInterface $service): Response
	{

		return $this->render("main\index.html.twig");

	}

}
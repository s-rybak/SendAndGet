<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/11/18
 * Time: 3:19 PM
 */

namespace App\Service;


use App\DTO\MainPageDTO;
use App\DTO\MainPageDTOInterface;
use App\Repository\PageRepositoryInterface;
use App\Resource\BreadCrumbsResource;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MainPageService implements MainPageServiceInterface {

	private $pageRepo;

	public function  __construct(PageRepositoryInterface $pageRepo) {

		$this->pageRepo = $pageRepo;

	}

	private function getBySlug(string $slug,string $lang = "en"): MainPageDTOInterface
	{

		$page = $this->pageRepo->getBySlug($slug,$lang);

		if(null === $page){

			throw new NotFoundHttpException("Page $slug ($lang) not found");

		}

		return new MainPageDTO($page,[
			new BreadCrumbsResource("Main","index"),
			new BreadCrumbsResource($page->getTitle(),$slug),
		]);

	}

	public function getAboutUs(string $lang="en"): MainPageDTOInterface {

		return $this->getBySlug('about_us',$lang);

	}

	public function getContuctAs(string $lang="en"): MainPageDTOInterface {

		return $this->getBySlug('contact_us',$lang);

	}

	public function getStatistic( string $lang = "en" ): MainPageDTOInterface {
		return $this->getBySlug('statistic',$lang);
	}

	public function getTOS( string $lang = "en" ): MainPageDTOInterface {
		return $this->getBySlug('tos',$lang);
	}

	public function getAPI( string $lang = "en" ): MainPageDTOInterface {
		return $this->getBySlug('api',$lang);
	}

	public function getFAQ( string $lang = "en" ): MainPageDTOInterface {
		return $this->getBySlug('faq',$lang);
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/11/18
 * Time: 3:19 PM.
 */

namespace App\Service;

use App\DTO\BreadcrumbsDTO;
use App\DTO\MainPageDTO;
use App\Repository\PageRepositoryInterface;

class MainPageService implements MainPageServiceInterface
{
    private $pageRepo;

    public function __construct(PageRepositoryInterface $pageRepo)
    {
        $this->pageRepo = $pageRepo;
    }

    public function getAboutUs(string $lang = 'en'): MainPageDTO
    {
        return $this->getBySlug('about_us', $lang);
    }

    public function getContuctAs(string $lang = 'en'): MainPageDTO
    {
        return $this->getBySlug('contact_us', $lang);
    }

    public function getStatistic(string $lang = 'en'): MainPageDTO
    {
        return $this->getBySlug('statistic', $lang);
    }

    public function getTOS(string $lang = 'en'): MainPageDTO
    {
        return $this->getBySlug('tos', $lang);
    }

    public function getAPI(string $lang = 'en'): MainPageDTO
    {
        return $this->getBySlug('api', $lang);
    }

    public function getFAQ(string $lang = 'en'): MainPageDTO
    {
        return $this->getBySlug('faq', $lang);
    }

    private function getBySlug(string $slug, string $lang = 'en'): MainPageDTO
    {
        $page = $this->pageRepo->getBySlug($slug, $lang);

        if (null === $page) {
            throw new EntityNotFoundException("Page $slug ($lang) not found");
        }

        return new MainPageDTO($page, [
            new BreadcrumbsDTO('Main', 'index'),
            new BreadcrumbsDTO($page->getTitle(), $slug),
        ]);
    }
}

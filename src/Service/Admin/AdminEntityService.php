<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Admin;

use App\Entity\Page;
use App\Entity\PageTranslation;
use App\Repository\PageRepositoryInterface;
use App\Repository\PageTranslationsRepositoryInterface;

class AdminEntityService implements AdminEntityServiceInterface
{
    private $pageRepo;
    private $pageTransRepo;

    public function __construct(
        PageRepositoryInterface $pageRepo,
        PageTranslationsRepositoryInterface $pageTransRepo
    ) {
        $this->pageRepo = $pageRepo;
        $this->pageTransRepo = $pageTransRepo;
    }

    public function getPages(int $page, int $perpage = 10): iterable
    {
        return $this->pageRepo->getList($page, $perpage);
    }

    public function getPageById(int $id): ?Page
    {
        return $this->pageRepo->getById($id);
    }

    public function savePage(Page $page): Page
    {
        return $this->pageRepo->save($page);
    }

    public function getTranslationByPageId(int $id, string $locale = 'en'): ?PageTranslation
    {
        return $this->pageTransRepo->getByPageId($id, $locale);
    }

    public function saveTranslation(PageTranslation $page): PageTranslation
    {
        return $this->pageTransRepo->save($page);
    }
}

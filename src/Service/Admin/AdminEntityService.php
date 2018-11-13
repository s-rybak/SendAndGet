<?php

namespace App\Service\Admin;

use App\Entity\Page;
use App\Repository\PageRepositoryInterface;

class AdminEntityService implements AdminEntityServiceInterface
{
    private $pageRepo;

    public function __construct(PageRepositoryInterface $pageRepo)
    {
        $this->pageRepo = $pageRepo;
    }

    public function getPages(int $page, int $perpage = 10): iterable
    {
        return $this->pageRepo->getList($page, $perpage);
    }

    public function getPageById(int $id): ?Page
    {
        return $this->pageRepo->getById($id);
    }
}

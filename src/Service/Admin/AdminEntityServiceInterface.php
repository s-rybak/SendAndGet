<?php

namespace App\Service\Admin;

use App\Entity\Page;

interface AdminEntityServiceInterface
{
    public function getPages(int $page, int $perpage = 10): iterable;

    public function getPageById(int $id): ?Page;
}

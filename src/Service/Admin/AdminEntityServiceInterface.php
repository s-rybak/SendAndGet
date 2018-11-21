<?php

namespace App\Service\Admin;

use App\Entity\Page;
use App\Entity\PageTranslation;

interface AdminEntityServiceInterface
{
    public function getPages(int $page, int $perpage = 10): iterable;

    public function getPageById(int $id): ?Page;

    public function getTranslationByPageId(int $id,string $locale = 'en'): ?PageTranslation;

    public function savePage(Page $page):Page;

    public function saveTranslation(PageTranslation $page):PageTranslation;
}

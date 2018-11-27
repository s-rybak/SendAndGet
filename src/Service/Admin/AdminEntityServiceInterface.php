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

interface AdminEntityServiceInterface
{
    public function getPages(int $page, int $perpage = 10): iterable;

    public function getPageById(int $id): ?Page;

    public function getTranslationByPageId(int $id, string $locale = 'en'): ?PageTranslation;

    public function savePage(Page $page): Page;

    public function saveTranslation(PageTranslation $page): PageTranslation;
}

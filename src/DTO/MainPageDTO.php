<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DTO;

use App\Entity\Page;

final class MainPageDTO
{
    private $page;
    private $breadcrumbs;

    public function __construct(Page $page, iterable $pbc)
    {
        $this->setBreadcrumbs($pbc);
        $this->setPage($page);
    }

    public function getPage(): Page
    {
        return $this->page;
    }

    public function setPage(Page $page): void
    {
        $this->page = $page;
    }

    public function getBreadcrumbs(): iterable
    {
        return $this->breadcrumbs;
    }

    public function setBreadcrumbs(iterable $pbc): void
    {
        $this->breadcrumbs = $pbc;
    }
}

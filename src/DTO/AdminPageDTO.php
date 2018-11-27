<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DTO;

final class AdminPageDTO
{
    private $title = 'Untitled';
    private $description = '';
    private $breadcrumbs = [];

    /**
     * Get admin page title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get admin page description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get page breadcrumbs.
     *
     * @return iterable
     */
    public function getBreadcrumbs(): iterable
    {
        return $this->breadcrumbs;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setBreadcrumbs(iterable $breadcrumbs): void
    {
        $this->breadcrumbs = $breadcrumbs;
    }
}

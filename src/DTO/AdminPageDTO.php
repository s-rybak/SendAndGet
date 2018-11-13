<?php

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

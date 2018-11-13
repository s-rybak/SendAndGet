<?php

namespace App\Service\Admin;

use App\DTO\AdminPageDTO;
use App\DTO\BreadcrumbsDTO;

class AdminPageService implements AdminPageServiceInterface
{
    public function getPagesResource(): AdminPageDTO
    {
        $resource = new AdminPageDTO();

        $breadcrumbs = [
            new BreadcrumbsDTO('Dashboard', 'admin_dashboard'),
            new BreadcrumbsDTO('Pages', 'admin_pages'),
        ];

        $resource->setTitle('Pages');
        $resource->setDescription('All site pages');
        $resource->setBreadcrumbs($breadcrumbs);

        return $resource;
    }

    public function getEditPageResource(string $pageTitle): AdminPageDTO
    {
        $resource = new AdminPageDTO();

        $breadcrumbs = [
            new BreadcrumbsDTO('Dashboard', 'admin_dashboard'),
            new BreadcrumbsDTO('Pages', 'admin_pages'),
        ];

        $resource->setTitle($pageTitle);
        $resource->setDescription('Edit page');
        $resource->setBreadcrumbs($breadcrumbs);

        return $resource;
    }
}

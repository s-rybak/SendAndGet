<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Builder;

use App\DTO\AdminPageDTO;
use App\DTO\BreadcrumbsDTO;

class AdminPageBuilder implements AdminPageBuilderInterface
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

    public function getAppApiResource(): AdminPageDTO
    {
        $resource = new AdminPageDTO();

        $breadcrumbs = [
            new BreadcrumbsDTO('Dashboard', 'admin_dashboard'),
            new BreadcrumbsDTO('Api apps', 'admin_apps'),
        ];

        $resource->setTitle('Api apps');
        $resource->setDescription('All api apps');
        $resource->setBreadcrumbs($breadcrumbs);

        return $resource;
    }

    public function getUsersResource(): AdminPageDTO
    {
        $resource = new AdminPageDTO();

        $breadcrumbs = [
            new BreadcrumbsDTO('Dashboard', 'admin_dashboard'),
            new BreadcrumbsDTO('Users', 'admin_users'),
        ];

        $resource->setTitle('Users');
        $resource->setDescription('All Users');
        $resource->setBreadcrumbs($breadcrumbs);

        return $resource;
    }

    public function getEditAppApiResource(string $pageTitle): AdminPageDTO
    {
        $resource = new AdminPageDTO();

        $breadcrumbs = [
            new BreadcrumbsDTO('Dashboard', 'admin_dashboard'),
            new BreadcrumbsDTO('Api apps', 'admin_apps'),
        ];

        $resource->setTitle($pageTitle);
        $resource->setDescription('Edit app');
        $resource->setBreadcrumbs($breadcrumbs);

        return $resource;
    }

    public function getFilesResource(): AdminPageDTO
    {
        $resource = new AdminPageDTO();

        $breadcrumbs = [
            new BreadcrumbsDTO('Dashboard', 'admin_dashboard'),
            new BreadcrumbsDTO('Files', 'admin_files'),
        ];

        $resource->setTitle('Uploaded files');
        $resource->setDescription('All uploaded files');
        $resource->setBreadcrumbs($breadcrumbs);

        return $resource;
    }

    public function getEditFilesResource(string $pageTitle): AdminPageDTO
    {
        $resource = new AdminPageDTO();

        $breadcrumbs = [
            new BreadcrumbsDTO('Dashboard', 'admin_dashboard'),
            new BreadcrumbsDTO('Files', 'admin_files'),
        ];

        $resource->setTitle($pageTitle);
        $resource->setDescription('Edit file');
        $resource->setBreadcrumbs($breadcrumbs);

        return $resource;
    }

    public function getDashboard(): AdminPageDTO
    {
        $resource = new AdminPageDTO();

        $resource->setTitle('Send and Get');
        $resource->setDescription('Admin dashboard');

        return $resource;
    }
}

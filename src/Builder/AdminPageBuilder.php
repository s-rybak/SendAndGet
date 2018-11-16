<?php

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

	public function getAppApiResource(): AdminPageDTO {
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

	public function getEditAppApiResource( string $pageTitle ): AdminPageDTO {
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
}

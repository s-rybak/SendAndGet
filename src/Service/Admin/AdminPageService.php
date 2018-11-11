<?php

namespace App\Service\Admin;

use App\Repository\PageRepositoryInterface;
use App\Resource\AdminPageResource;
use App\Resource\AdminPageResourceInterface;
use App\Resource\BreadCrumbsResource;

class AdminPageService implements AdminPageServiceInterface {

	public function getPagesResource( ): AdminPageResourceInterface {

		$resource = new AdminPageResource();

		$breadcrumbs = [
			new BreadCrumbsResource("Dashboard","admin_dashboard"),
			new BreadCrumbsResource("Pages","admin_pages"),
		];

		$resource->setTitle("Pages");
		$resource->setDescription("All site pages");
		$resource->setBreadcrumbs($breadcrumbs);

		return $resource;

	}

	public function getEditPageResource(string $pageTitle): AdminPageResourceInterface {

		$resource = new AdminPageResource();

		$breadcrumbs = [
			new BreadCrumbsResource("Dashboard","admin_dashboard"),
			new BreadCrumbsResource("Pages","admin_pages"),
		];

		$resource->setTitle($pageTitle);
		$resource->setDescription("Edit page");
		$resource->setBreadcrumbs($breadcrumbs);

		return $resource;

	}

}
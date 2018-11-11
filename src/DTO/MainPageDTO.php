<?php

namespace App\DTO;

use App\Entity\Page;
use App\Resource\BreadcrumbsResourceInterface;

class MainPageDTO implements MainPageDTOInterface {

	private $page;
	private $breadcrumbs;

	public function __construct(Page $page,iterable $pbc) {

		$this->setBreadcrumbs($pbc);
		$this->setPage($page);

	}

	public function getPage(): Page {
		return $this->page;
	}

	public function setPage( Page $page ): void {
		$this->page = $page;
	}

	public function getBreadcrumbs(): iterable {
		return $this->breadcrumbs;
	}

	public function setBreadcrumbs( iterable $pbc ): void {
		$this->breadcrumbs = $pbc;
	}
}
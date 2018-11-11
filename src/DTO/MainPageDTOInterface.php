<?php
namespace App\DTO;


use App\Entity\Page;
use App\Resource\BreadcrumbsResourceInterface;

interface MainPageDTOInterface {

	public function getPage():Page;
	public function setPage(Page $page):void;
	public function getBreadcrumbs():iterable;
	public function setBreadcrumbs(iterable $pbc):void;

}
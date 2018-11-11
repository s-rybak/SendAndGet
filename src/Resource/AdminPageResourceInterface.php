<?php

namespace App\Resource;

/**
 * Provides Admin Page resource functionality
 * @package App\Resource
 */
interface AdminPageResourceInterface {

	/**
	 * Get admin page title
	 * @return string
	 */
	public function getTitle():string;
	/**
	 * Get admin page description
	 * @return string
	 */
	public function getDescription():string;

	public function getBreadcrumbs(): iterable;

	public function setTitle(string $title):void;

	public function setDescription(string $descriptio):void;

	public function setBreadcrumbs(iterable $breadcrumbs):void;

}
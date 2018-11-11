<?php

namespace App\Service\Admin;
use App\Resource\AdminPageResourceInterface;

/**
 * Interface AdminPageServiceInterface
 * @package App\Service\Admin
 */

interface AdminPageServiceInterface {

	public function getPagesResource():AdminPageResourceInterface;
	public function getEditPageResource(string $pageTitle):AdminPageResourceInterface;

}
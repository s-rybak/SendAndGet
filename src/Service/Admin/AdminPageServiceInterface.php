<?php

namespace App\Service\Admin;

use App\DTO\AdminPageDTO;

/**
 * Interface AdminPageServiceInterface.
 */
interface AdminPageServiceInterface
{
    public function getPagesResource(): AdminPageDTO;

    public function getEditPageResource(string $pageTitle): AdminPageDTO;
}

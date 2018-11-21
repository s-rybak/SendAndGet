<?php

namespace App\Builder;

use App\DTO\AdminPageDTO;

/**
 * Interface AdminPageServiceInterface.
 */
interface AdminPageBuilderInterface
{
    public function getPagesResource(): AdminPageDTO;

    public function getEditPageResource(string $pageTitle): AdminPageDTO;

    public function getAppApiResource(): AdminPageDTO;

    public function getEditAppApiResource(string $pageTitle): AdminPageDTO;

    public function getFilesResource(): AdminPageDTO;

    public function getEditFilesResource(string $pageTitle): AdminPageDTO;

    public function getDashboard(): AdminPageDTO;
}

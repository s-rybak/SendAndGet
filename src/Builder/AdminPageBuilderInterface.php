<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

    public function getUsersResource(): AdminPageDTO;

    public function getDownloadsResource(): AdminPageDTO;

    public function getEditUserResource(string $pageTitle): AdminPageDTO;

    public function getEditAppApiResource(string $pageTitle): AdminPageDTO;

    public function getFilesResource(): AdminPageDTO;

    public function getEditFilesResource(string $pageTitle): AdminPageDTO;

    public function getDashboard(): AdminPageDTO;
}

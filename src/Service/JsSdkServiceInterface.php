<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\DTO\JsSdkDTO;

/**
 * Provides js sdk service functions.
 */
interface JsSdkServiceInterface
{
    public function getJsSdkDto(string $api): JsSdkDTO;
}

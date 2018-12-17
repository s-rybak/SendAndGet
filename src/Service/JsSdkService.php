<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\DTO\JsSdkDTO;

class JsSdkService implements JsSdkServiceInterface
{
    public function getJsSdkDto(string $api): JsSdkDTO
    {
        return new JsSdkDTO(
            $api,
            '/api/files/upload',
            1000,
            '/api/files/list',
            '/api/files/query',
            '/api/files/delete',
            '/api/app/stat'
        );
    }
}

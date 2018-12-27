<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\User;

use App\Entity\File;
use App\Entity\FileUser;
use App\Entity\User;

interface FileUserServiceIntervface
{
    public function addDownload(User $user, File $file): FileUser;

    public function addDownloadMany(User $user, array $files): iterable;

    public function getByUserId(int $id, int $page = 1, int $perpage = 10): iterable;

    public function getByFileId(int $id, int $page = 1, int $perpage = 10): iterable;
}

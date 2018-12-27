<?php

namespace App\Service\User;

use App\Entity\File;
use App\Entity\FileUser;
use App\Entity\User;

interface FileUserServiceIntervface {

	public function addDownload(User $user, File $file):FileUser;

	public function addDownloadMany(User $user, array $files):iterable;

	public function getByUserId(int $id, int $page = 1, int $perpage = 10):iterable;

	public function getByFileId(int $id, int $page = 1, int $perpage = 10):iterable;


}
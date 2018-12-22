<?php

namespace App\Service\User;

use App\Entity\File;
use App\Entity\FileUser;
use App\Entity\User;

interface FileUserServiceIntervface {

	public function addDownload(User $user, File $file):FileUser;

	public function addDownloadMany(User $user, array $files):iterable;


}
<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\DTO\SiteStatisticDTO;
use App\Repository\ApiAppRepositoryInterface;
use App\Repository\FileRepositiryInterface;

class SiteStatisticService implements SiteStatisticServiceIntervace
{
    private $filesRepo;
    private $appApiRepo;

    public function __construct(
        FileRepositiryInterface $files_repo,
        ApiAppRepositoryInterface $api_repo
    ) {
        $this->appApiRepo = $api_repo;
        $this->filesRepo = $files_repo;
    }

    public function getDashboardStatistic(): SiteStatisticDTO
    {
        $stat = new SiteStatisticDTO();

        $stat->setAppsCount($this->appApiRepo->length());
        $stat->setApiCalls($this->appApiRepo->getAppCallsCount());
        $stat->setFilesCount($this->filesRepo->length());
        $stat->setStorageUsed($this->filesRepo->getFilesSize());

        return $stat;
    }
}

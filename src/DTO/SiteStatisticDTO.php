<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DTO;

class SiteStatisticDTO
{
    private $filesCount = 0;
    private $storageUsed = 0;
    private $appsCount = 0;
    private $apiCalls = 0;

    /**
     * @return int
     */
    public function getFilesCount(): int
    {
        return $this->filesCount;
    }

    /**
     * @param int $filesCount
     */
    public function setFilesCount(int $filesCount): void
    {
        $this->filesCount = $filesCount;
    }

    /**
     * @return float
     */
    public function getStorageUsed(): float
    {
        return $this->storageUsed;
    }

    /**
     * @param float $storageUsed
     */
    public function setStorageUsed(float $storageUsed): void
    {
        $this->storageUsed = $storageUsed;
    }

    /**
     * @return int
     */
    public function getAppsCount(): int
    {
        return $this->appsCount;
    }

    /**
     * @param int $apps
     */
    public function setAppsCount(int $apps): void
    {
        $this->appsCount = $apps;
    }

    /**
     * @return int
     */
    public function getApiCalls(): int
    {
        return $this->apiCalls;
    }

    /**
     * @param int $apiCalls
     */
    public function setApiCalls(int $apiCalls): void
    {
        $this->apiCalls = $apiCalls;
    }
}

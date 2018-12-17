<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\DTO\AppStatisticDTO;
use App\DTO\SiteStatisticDTO;

interface SiteStatisticServiceIntervace
{
    public function getDashboardStatistic(): SiteStatisticDTO;

    public function getAppStistic(int $id): AppStatisticDTO;
}

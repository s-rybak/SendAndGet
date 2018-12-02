<?php

namespace App\Service;

use App\DTO\SiteStatisticDTO;

interface SiteStatisticServiceIntervace {

	public function getDashboardStatistic(): SiteStatisticDTO;

}
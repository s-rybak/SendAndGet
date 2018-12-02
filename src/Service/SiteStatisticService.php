<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 12/2/18
 * Time: 4:28 PM
 */

namespace App\Service;

use App\DTO\SiteStatisticDTO;
use App\Repository\ApiAppRepositoryInterface;
use App\Repository\FileRepositiryInterface;
use App\Service\Files\FilesServiceInterface;

class SiteStatisticService implements SiteStatisticServiceIntervace {

	private $filesRepo;
	private $appApiRepo;

	public function __construct(
		FileRepositiryInterface $files_repo,
		ApiAppRepositoryInterface $api_repo
	) {

		$this->appApiRepo = $api_repo;
		$this->filesRepo = $files_repo;

	}

	public function getDashboardStatistic(): SiteStatisticDTO {

		$stat = new SiteStatisticDTO();

		$stat->setAppsCount($this->appApiRepo->length());
		$stat->setApiCalls($this->appApiRepo->getAppCallsCount());
		$stat->setFilesCount($this->filesRepo->length());
		$stat->setStorageUsed($this->filesRepo->getFilesSize());

		return $stat;

	}

}
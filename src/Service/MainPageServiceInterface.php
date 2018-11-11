<?php

namespace App\Service;
use App\DTO\MainPageDTOInterface;

/**
 * Main page service
 * service interface that provides
 * main page data
 *
 * @author Sergey R <qwe@qwe.com>
 * @package App\Service
 */
interface MainPageServiceInterface {

	public function getAboutUs(string $lang = "en"):MainPageDTOInterface;
	public function getContuctAs(string $lang = "en"):MainPageDTOInterface;
	public function getStatistic(string $lang = "en"):MainPageDTOInterface;
	public function getTOS(string $lang = "en"):MainPageDTOInterface;
	public function getAPI(string $lang = "en"):MainPageDTOInterface;
	public function getFAQ(string $lang = "en"):MainPageDTOInterface;


}
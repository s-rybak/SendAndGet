<?php

namespace App\Service;

use App\DTO\MainPageDTO;

/**
 * Main page service
 * service interface that provides
 * main page data.
 *
 * @author Sergey R <qwe@qwe.com>
 */
interface MainPageServiceInterface
{
    public function getAboutUs(string $lang = 'en'): MainPageDTO;

    public function getContuctAs(string $lang = 'en'): MainPageDTO;

    public function getStatistic(string $lang = 'en'): MainPageDTO;

    public function getTOS(string $lang = 'en'): MainPageDTO;

    public function getAPI(string $lang = 'en'): MainPageDTO;

    public function getFAQ(string $lang = 'en'): MainPageDTO;

    public function getCurrentLocale():string;

    public function setCurrentLocale(string $locale):void;
}

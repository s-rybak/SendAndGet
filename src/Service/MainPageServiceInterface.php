<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
    public function getMainPageGet(string $lang = 'en'): MainPageDTO;

    public function getMainPageSend(string $lang = 'en'): MainPageDTO;

    public function getAboutUs(string $lang = 'en'): MainPageDTO;

    public function getContuctAs(string $lang = 'en'): MainPageDTO;

    public function getStatistic(string $lang = 'en'): MainPageDTO;

    public function getTOS(string $lang = 'en'): MainPageDTO;

    public function getAPI(string $lang = 'en'): MainPageDTO;

    public function getFAQ(string $lang = 'en'): MainPageDTO;

    public function getCurrentLocale(): string;

    public function setCurrentLocale(string $locale): void;
}

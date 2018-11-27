<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\ApiApp;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Provides App api
 * manage functionality.
 */
interface AppApiServiceInterface
{
    public function save(ApiApp $app): ApiApp;

    public function getById(int $id): ?ApiApp;

    public function getList(int $page, int $perpage = 10): iterable;

    public function getByKey(string $key): ?ApiApp;

    public function generateKeys(ApiApp $app): ApiApp;

    public function decodeApiKey(string $key): array;

    public function checkAppApiKey(string $key, UserInterface $app): bool;

    public function checkApiKey(string $key): bool;
}

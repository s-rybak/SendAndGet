<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\User;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface UserServiceInterface.
 *
 * Manage users entity
 */
interface UserServiceInterface
{
    public function save(User $user): User;

    public function remove(User $user): void;

    public function getById(int $id): ?User;

    public function getByIp(string $ip, int $page = 1, int $perpage = 10): iterable;

    public function getDownloads(int $page = 1, int $perpage = 10): iterable;

    public function setStatusByIp(string $ip, string $status): void;

    public function getAll(int $page, int $perpage = 10): iterable;

    public function getCreateServiceUser(Request $request): User;

    public function getByStatus(string $status, int $page = 1, int $perpage = 10): iterable;
}

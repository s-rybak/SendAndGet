<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\User;

interface UserRpositoryInterface
{
    public function save($user);

    public function remove($user):void;

    public function getById(int $id);

    public function getByIp(string $ip,int $page = 1, int $perpage = 10):iterable;

    public function getByDevice(string $device,int $page = 1, int $perpage = 10):iterable;

    public function getByDeviceAndIp(string $ip, string $device): ?User;

    public function getList(int $page, int $perpage = 10);

    public function length();

    public function getCreateServiceUser(string $ip, string $device): User;

    public function getByStatus(string $status, int $page = 1, int $perpage = 10): iterable;

}

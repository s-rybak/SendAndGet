<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\ApiApp;

/**
 * Provides App api db manage
 * functionality.
 */
interface ApiAppRepositoryInterface
{
    public function save($app);

    public function getById(int $id);

    public function getList(int $page, int $perpage = 10): iterable;

    public function getByKey(string $key): ?ApiApp;
}

<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Page;

interface PageRepositoryInterface
{
    public function getList(int $page, int $perpage): iterable;

    public function getById(int $id);

    public function getBySlug(string $slug): ?Page;

    public function save($page);
}

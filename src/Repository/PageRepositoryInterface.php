<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/11/18
 * Time: 12:46 PM.
 */

namespace App\Repository;

use App\Entity\Page;

interface PageRepositoryInterface
{
    public function getList(int $page, int $perpage): iterable;

    public function getById(int $id): ?Page;

    public function getBySlug(string $slug): ?Page;
}

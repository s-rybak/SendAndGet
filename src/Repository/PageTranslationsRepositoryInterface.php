<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\PageTranslation;

interface PageTranslationsRepositoryInterface
{
    public function save($page);

    public function getByPageId(int $id, string $locale = 'en'): ?PageTranslation;
}

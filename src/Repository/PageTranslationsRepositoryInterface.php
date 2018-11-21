<?php

namespace App\Repository;


use App\Entity\PageTranslation;

interface PageTranslationsRepositoryInterface {

	public function save($page);

	public function getByPageId(int $id, string $locale = 'en'):?PageTranslation;

}
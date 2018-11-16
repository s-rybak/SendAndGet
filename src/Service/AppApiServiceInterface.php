<?php

namespace App\Service;
use App\Entity\ApiApp;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Provides App api
 * manage functionality
 * @package App\Service
 */

interface AppApiServiceInterface {

	public function save(ApiApp $app):ApiApp;

	public function getById(int $id):?ApiApp;

	public function getList(int $page, int $perpage = 10):iterable;

	public function getByKey(string $key):?ApiApp;

	public function generateKeys(ApiApp $app):ApiApp;

	public function decodeApiKey(string $key):array;

	public function checkAppApiKey(string $key, UserInterface $app):bool;

	public function checkApiKey(string $key):bool;

}
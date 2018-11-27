<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\ApiApp;
use App\Repository\ApiAppRepositoryInterface;
use App\Util\PasswordUtil;
use Symfony\Component\Security\Core\User\UserInterface;

class AppApiService implements AppApiServiceInterface
{
    private $repository;

    public function __construct(ApiAppRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function save(ApiApp $app): ApiApp
    {
        if (null === $app->getId()) {
            $app->setCreatedAt(new \DateTime('now'));
            $app->setCallsCount(0);
            $app = $this->generateKeys($app);
        }

        $app->setUpdatedAt(new \DateTime('now'));

        return $this->repository->save($app);
    }

    public function getById(int $id): ?ApiApp
    {
        return $this->repository->getById($id);
    }

    public function getList(int $page, int $perpage = 10): iterable
    {
        return $this->repository->getList($page, $perpage);
    }

    public function generateKeys(ApiApp $app): ApiApp
    {
        $app->setLiveKey(
            $this->generateKey(
                $app->getContactEmail(),
                'live'
            )
        );

        $app->setTestKey(
            $this->generateKey(
                $app->getContactEmail(),
                'test'
            )
        );

        $app->setSecret(PasswordUtil::generatePssword());

        return $app;
    }

    private function generateKey(string $user_mail, string $type)
    {
        return "{$type}_".strrev(preg_replace('/=+$/', '', base64_encode(json_encode([
                'user_mail' => $user_mail,
                'uniq_hash' => uniqid(),
                'type' => $type,
            ]))));
    }

    public function decodeApiKey(string $key): array
    {
        $typePos = strpos($key, '_');
        if (false !== $typePos) {
            $key = substr($key, $typePos);
        }

        return json_decode(base64_decode(strrev($key)), true);
    }

    public function checkAppApiKey(string $key, UserInterface $app): bool
    {
        $keyData = $this->decodeApiKey($key);

        return $app->getContactEmail() === $keyData['user_mail'] &&
               0 === strpos($key, $keyData['type']) &&
               strlen($keyData['uniq_hash']) > 2;
    }

    public function checkApiKey(string $key): bool
    {
        $app = $this->getByKey($key);

        if (null === $app) {
            return false;
        }

        $keyData = $this->decodeApiKey($key);

        return $app->getContactEmail() === $keyData['user_mail'] &&
               0 === strpos($key, $keyData['type']) &&
               strlen($keyData['uniq_hash']) > 2;
    }

    public function getByKey(string $key): ?ApiApp
    {
        return $this->repository->getByKey($key);
    }
}

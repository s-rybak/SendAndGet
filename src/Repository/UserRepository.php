<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRpositoryInterface
{
    use RepositoryStandartFunctionsTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getCreateServiceUser(string $ip, string $device): User
    {
        $user = $this->getByDeviceAndIp($ip, $device);

        if (null === $user) {
            $user = new User();

            $user->setUserRoles(['ROLE_SERVICE_USER']);
            $user->setUsername(uniqid('user_'));
            $user->setPassword('');
            $user->setEmail('');
            $user->setIp($ip);
            $user->setDevice($device);
            $user->setStatus('active');

            return $this->save($user);
        }

        return $user;
    }

    public function getByIp(string $ip, int $page = 1, int $perpage = 10): iterable
    {
        return $this->findBy(['ip' => $ip], null, $perpage, ($page - 1) * $perpage);
    }

    public function getByDevice(string $device, int $page = 1, int $perpage = 10): iterable
    {
        return $this->findBy(['device' => $device], null, $perpage, ($page - 1) * $perpage);
    }

    public function getByDeviceAndIp(string $ip, string $device): ?User
    {
        return $this->findOneBy(['device' => $device, 'ip' => $ip]);
    }

    public function getByStatus(string $status, int $page = 1, int $perpage = 10): iterable
    {
        return $this->findBy(['status' => $status], null, $perpage, ($page - 1) * $perpage);
    }

    public function setStatusByIp(string $ip, string $status): void
    {
        $this
            ->createQueryBuilder('f')
            ->update()
            ->set('f.status', ':status')
            ->where('f.ip = :ip')
            ->setParameter('ip', $ip)
            ->setParameter('status', $status)
            ->getQuery()
            ->execute();
    }
}

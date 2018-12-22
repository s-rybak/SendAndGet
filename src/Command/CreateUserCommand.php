<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRpositoryInterface;
use App\Util\PasswordUtil;
use Complex\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    private $userRepo;
    private $passwordEnc;

    public function __construct(UserPasswordEncoderInterface $pass, UserRpositoryInterface $userRepo, string $name = null)
    {
        parent::__construct($name);

        $this->userRepo = $userRepo;
        $this->passwordEnc = $pass;
    }

    public function configure()
    {
        $this->setName('app:create:user')
             ->setDescription('Create new user')
             ->addArgument('usernamae', InputArgument::REQUIRED, 'user name')
             ->addArgument('email', InputArgument::REQUIRED, 'useremaail')
             ->addArgument('password', InputArgument::OPTIONAL, 'user password');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Creating new user');

        $usernamae = $input->getArgument('usernamae');
        $email = $input->getArgument('email');
        $passwd = $input->getArgument('password') ?? PasswordUtil::generatePssword();

        $user = new User();

        $pass = $this->passwordEnc->encodePassword($user, $passwd);

        $user->setEmail($email);
        $user->setUsername($usernamae);
        $user->setPassword($pass);
        $user->setStatus('active');
        $user->setUserRoles(['ROLE_ADMIN']);

        try {
            $this->userRepo->save($user);

            if (null == $input->getArgument('password')) {
                $output->writeln("<info>Your password: {$passwd}</info>");
            }

            $output->writeln("User ({$usernamae}) created");
        } catch (Exception $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");
        }
    }
}

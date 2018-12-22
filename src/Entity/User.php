<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $password;

    /**
     * @ORM\Column(name="is_active", type="boolean", options={"default":true})
     */
    private $isActive = true;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
    private $ip;

    /**
	 * @ORM\Column(type="text")
	 */
    private $device;

    /**
	 * @ORM\Column(type="text")
	 */
    private $user_roles;

    /**
	 * @ORM\Column(type="string", length=100)
	 */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->getUserRoles();
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return null;
    }

    /**
     * String representation of object.
     *
     * @see http://php.net/manual/en/serializable.serialize.php
     *
     * @return string the string representation of the object or null
     *
     * @since 5.1.0
     */
    public function serialize()
    {
        return \serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }

    /**
     * Constructs the object.
     *
     * @see http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     *
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        [
            $this->id,
            $this->username,
            $this->password
        ] = \unserialize($serialized, ['allowed_classes' => true]);
    }

    public function getLocale(): string
    {
        return 'ua';
    }

	/**
	 * @return mixed
	 */
	public function getIp():string
	{
		return $this->ip;
	}

	/**
	 * @param mixed $ip
	 */
	public function setIp(string $ip ): void {
		$this->ip = $ip;
	}

	/**
	 * @return mixed
	 */
	public function getDevice():string
	{
		return $this->device;
	}

	/**
	 * @param mixed $device
	 */
	public function setDevice(string $device ): void {
		$this->device = $device;
	}

	/**
	 * @return mixed
	 */
	public function getUserRolesRaw():string {
		return $this->user_roles;
	}

	/**
	 * @return mixed
	 */
	public function getUserRoles():array {
		return explode(",",$this->user_roles);
	}

	/**
	 * @param array $user_roles
	 */
	public function setUserRoles(array $user_roles ): void {
		$this->user_roles = implode(",",$user_roles);
	}

	/**
	 * @return string
	 */
	public function getStatus():string {
		return $this->status;
	}

	/**
	 * @param string $status
	 */
	public function setStatus(string $status ): void {
		$this->status = $status;
	}
}

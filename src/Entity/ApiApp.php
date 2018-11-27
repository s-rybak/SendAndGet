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
 * @ORM\Entity(repositoryClass="App\Repository\ApiAppRepository")
 */
class ApiApp implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $host;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $contact_email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $live_key;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $test_key;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $secret;

    /**
     * @ORM\Column(type="integer")
     */
    private $limits;

    /**
     * @ORM\Column(type="integer")
     */
    private $storage;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $calls_count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setHost(?string $Host): self
    {
        $this->host = $Host;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contact_email;
    }

    public function setContactEmail(string $contact_email): self
    {
        $this->contact_email = $contact_email;

        return $this;
    }

    public function getLiveKey(): ?string
    {
        return $this->live_key;
    }

    public function setLiveKey(string $live_key): self
    {
        $this->live_key = $live_key;

        return $this;
    }

    public function getTestKey(): ?string
    {
        return $this->test_key;
    }

    public function setTestKey(string $test_key): self
    {
        $this->test_key = $test_key;

        return $this;
    }

    public function getLimits(): ?int
    {
        return $this->limits;
    }

    public function setLimits(int $limits): self
    {
        $this->limits = $limits;

        return $this;
    }

    public function getStorage(): ?int
    {
        return $this->storage;
    }

    public function setStorage(int $storage): self
    {
        $this->storage = $storage;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getCallsCount(): ?int
    {
        return $this->calls_count;
    }

    public function setCallsCount(int $calls_count): self
    {
        $this->calls_count = $calls_count;

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
        return ['API_APP'];
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
            $this->contact_email,
            $this->secret,
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
            $this->contact_email,
        ] = \unserialize($serialized, ['allowed_classes' => true]);
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->getSecret();
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getContactEmail();
    }

    /**
     * @return mixed
     */
    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * @param mixed $secret
     */
    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }
}

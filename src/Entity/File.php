<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 */
class File {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=100)
	 *
	 * @Assert\NotBlank(message="Please, upload file.")
	 * @Assert\File(maxSize="10000M")
	 */
	private $path;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=10)
	 */
	private $type;

	/**
	 * @ORM\Column(type="string", length=10)
	 */
	private $status;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $app_id;

	/**
	 * @ORM\Column(type="string", length=30)
	 */
	private $hash;

	/**
	 * @ORM\Column(type="string", length=30)
	 */
	private $group_hash;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $aviable_at;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $created_at;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $updated_at;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $deletes_in;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $life_time;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $size;


	public function __construct() {
		$this->updated_at = new \DateTime();
		$this->created_at = new \DateTime();
		$this->aviable_at = new \DateTime();
		$this->hash       = uniqid();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getPath(): ?string {
		return $this->path;
	}

	public function setPath( string $path ): self {
		$this->path = $path;

		return $this;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName( string $name ): self {
		$this->name = $name;

		return $this;
	}

	public function getType(): ?string {
		return $this->type;
	}

	public function setType( string $type ): self {
		$this->type = $type;

		return $this;
	}

	public function getStatus(): ?string {
		return $this->status;
	}

	public function setStatus( string $status ): self {
		$this->status = $status;

		return $this;
	}

	public function getAviableAt(): ?\DateTimeInterface {
		return $this->aviable_at;
	}

	public function setAviableAt( \DateTimeInterface $aviable_at ): self {
		$this->aviable_at = $aviable_at;

		return $this;
	}

	public function getCreatedAt(): ?\DateTimeInterface {
		return $this->created_at;
	}

	public function setCreatedAt( \DateTimeInterface $created_at ): self {
		$this->created_at = $created_at;

		return $this;
	}

	public function getUpdatedAt(): ?\DateTimeInterface {
		return $this->updated_at;
	}

	public function setUpdatedAt( \DateTimeInterface $updated_at ): self {
		$this->updated_at = $updated_at;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getAppId(): int {
		return $this->app_id;
	}

	/**
	 * @param mixed $app_id
	 *
	 * @return File
	 */
	public function setAppId( int $app_id ): self {
		$this->app_id = $app_id;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHash() {
		return $this->hash;
	}

	/**
	 * @param string $hash
	 *
	 * @return File
	 */
	public function setHash( string $hash ): self {
		$this->hash = $hash;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getGroupHash(): string {
		return $this->group_hash;
	}

	/**
	 * @param string $group_hash
	 *
	 * @return File
	 */
	public function setGroupHash( string $group_hash ): self {
		$this->group_hash = $group_hash;

		return $this;
	}

	/**
	 * @return integer
	 */
	public function getTimeLeft(): int {

		return ( $this
			         ->getDeletesIn()
			         ->getTimestamp() - time()
		       ) / ( $this->getLifeTime() * 86400 ) * 100;
	}

	/**
	 * @return mixed
	 */
	public function getDeletesIn(): ?\DateTimeInterface {
		return $this->deletes_in;
	}

	/**
	 * @param mixed $deletes_in
	 *
	 * @return File
	 */
	public function setDeletesIn( \DateTimeInterface $deletes_in ): self {
		$this->deletes_in = $deletes_in;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLifeTime(): int {
		return $this->life_time;
	}

	/**
	 * @param mixed $life_time
	 *
	 * @return File
	 */
	public function setLifeTime( $life_time ): self {
		$this->life_time = $life_time;

		$exp = new \DateTime();
		$exp->setTimestamp(
			strtotime(
				"+{$life_time} day",
				$this->getAviableAt()->getTimestamp()
			)
		);

		$this->setDeletesIn( $exp );

		return $this;
	}

	/**
	 * @return int
	 */
	public function getSize():int {
		return $this->size;
	}

	/**
	 * @param mixed $size
	 *
	 * @return File
	 */
	public function setSize( $size ): self {
		$this->size = $size;

		return $this;
	}

}

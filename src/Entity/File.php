<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
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
	 *
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
	 */
	public function setAppId( int $app_id ): void {
		$this->app_id = $app_id;
	}

	/**
	 * @return string
	 */
	public function getHash() {
		return $this->hash;
	}

	/**
	 * @param string $hash
	 */
	public function setHash( string $hash ): void {
		$this->hash = $hash;
	}

	/**
	 * @return string
	 */
	public function getGroupHash():string {
		return $this->group_hash;
	}

	/**
	 * @param string $group_hash
	 */
	public function setGroupHash( string $group_hash ): void {
		$this->group_hash = $group_hash;
	}
}

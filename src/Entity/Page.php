<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $parent_id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $excerpt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $lang;

    /**
     * @OneToMany(targetEntity="Page", mappedBy="parent")
     */
    private $translations;

    /**
     * @ManyToOne(targetEntity="Page", inversedBy="translations")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

	public function __construct() {
		$this->translations = new \Doctrine\Common\Collections\ArrayCollection();
	}
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(?string $excerpt): self
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

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

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image ?? "https://place-hold.it/373x250";
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getTranslations():iterable {
		return $this->translations;
	}

	/**
	 * @param mixed $translations
	 */
	public function setTranslations( $translations ): void {
		$this->translations = $translations;
	}

	/**
	 * @return int
	 */
	public function getParentId():int
	{
		return $this->parent_id;
	}

	/**
	 * @param int $parent_id
	 */
	public function setParentId(int $parent_id ): void {
		$this->parent_id = $parent_id;
	}

	/**
	 * @return mixed
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @param mixed $parent
	 */
	public function setParent( $parent ): void {
		$this->parent = $parent;
	}
}

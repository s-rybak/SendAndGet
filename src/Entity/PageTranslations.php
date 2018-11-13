<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageTranslationsRepository")
 */
class PageTranslations
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $page_id;

    /**
     * @ManyToOne(targetEntity="Page", inversedBy="translations")
     * @JoinColumn(name="page_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $excerpt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=100,  columnDefinition="ENUM('published', 'draft')" )
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $lang;

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

    public function getPageId(): ?int
    {
        return $this->page_id;
    }

    public function setPageId(int $page_id): self
    {
        $this->page_id = $page_id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

}

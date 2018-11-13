<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/10/18
 * Time: 10:49 PM.
 */

namespace App\DTO;

class BreadcrumbsDTO
{
    private $link;
    private $title;

    public function __construct(string $title, string $link)
    {
        $this->setTitle($title);
        $this->setLink($link);
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setLink(string $link)
    {
        $this->link = $link;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }
}

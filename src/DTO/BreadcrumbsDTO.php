<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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

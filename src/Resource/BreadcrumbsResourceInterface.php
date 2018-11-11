<?php

namespace App\Resource;


interface BreadcrumbsResourceInterface {

	public function getLink():string;
	public function getTitle():string;
	public function setLink(string $link);
	public function setTitle(string $title);

}
<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DTO;

final class FileBagSizeDTO
{
    private $size = 0;
    private $maxFileSize = 0;
    private $maxFileName = "";

	/**
	 * @return float
	 */
	public function getSize(): float {
		return $this->size;
	}

	/**
	 * @param float $size
	 */
	public function setSize( float $size ): void {
		$this->size = $size;
	}

	/**
	 * @return float
	 */
	public function getMaxFileSize(): float {
		return $this->maxFileSize;
	}

	/**
	 * @param float $maxFile
	 */
	public function setMaxFileSize( float $maxFile ): void {
		$this->maxFileSize = $maxFile;
	}

	/**
	 * @return string
	 */
	public function getMaxFileName(): string {
		return $this->maxFileName;
	}

	/**
	 * @param string $maxFileName
	 */
	public function setMaxFileName( string $maxFileName ): void {
		$this->maxFileName = $maxFileName;
	}

	public function countFile(float $size,$name){

		$this->setSize($this->getSize() + $size);

		if($this->getMaxFileSize() < $size){

			$this->setMaxFileSize($size);
			$this->setMaxFileName($name);

		}

	}

}

<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Exceptions;

/**
 * Exception throws when
 * files remove process throws errors.
 *
 */
class FilesRemoveExceptionsPack extends \DomainException
{
	private $errors = [];

	/**
	 * @return array
	 */
	public function getErrors(): array {
		return $this->errors;
	}

	/**
	 * @param array $errors
	 */
	public function setErrors( array $errors ): void {
		$this->errors = $errors;
	}
}

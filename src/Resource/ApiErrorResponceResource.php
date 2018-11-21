<?php

namespace App\Resource;

class ApiErrorResponceResource {

	private $status;
	private $message;
	private $data;

	public function __construct(
		string $message,
		string $status = "error",
		$data = []
	) {

		$this->setStatus( $status );
		$this->setData( $data );
		$this->setMessage( $message );

	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param mixed $status
	 */
	public function setStatus(
		$status
	): void {
		$this->status = $status;
	}

	/**
	 * @return mixed
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @param mixed $message
	 */
	public function setMessage(
		$message
	): void {
		$this->message = $message;
	}

	/**
	 * @return mixed
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @param mixed $data
	 */
	public function setData(
		$data
	): void {
		$this->data = $data;
	}


}
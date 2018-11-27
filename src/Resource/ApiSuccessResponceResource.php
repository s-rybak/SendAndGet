<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Resource;

class ApiSuccessResponceResource
{
    private $status;
    private $message;
    private $data;

    public function __construct(
        $data = [],
        string $status = 'success',
        string $message = ''
    ) {
        $this->setStatus($status);
        $this->setData($data);
        $this->setMessage($message);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
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
    public function getMessage()
    {
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
    public function getData()
    {
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

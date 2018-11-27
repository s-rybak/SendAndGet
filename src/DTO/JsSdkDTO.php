<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DTO;

/**
 * Contains js sdk necessary data.
 */
class JsSdkDTO
{
    private $api_key;
    private $max_files_count;
    private $upload_url;
    private $delete_url;
    private $file_list;
    private $file_query;

    public function __construct(
        string $api_key,
        string $upload_url,
        int $max_files_count,
        string $file_list,
        string $file_query,
        string $delete_url
    ) {
        $this->api_key = $api_key;
        $this->max_files_count = $max_files_count;
        $this->upload_url = $upload_url;
        $this->file_list = $file_list;
        $this->file_query = $file_query;
        $this->delete_url = $delete_url;
    }

    /**
     * @return mixed
     */
    public function getApiKey(): string
    {
        return $this->api_key;
    }

    /**
     * @param string $api_key
     */
    public function setApiKey(string $api_key): void
    {
        $this->api_key = $api_key;
    }

    /**
     * @return mixed
     */
    public function getMaxFilesCount(): int
    {
        return $this->max_files_count;
    }

    /**
     * @param int $max_files_count
     */
    public function setMaxFilesCount(int $max_files_count): void
    {
        $this->max_files_count = $max_files_count;
    }

    /**
     * @return mixed
     */
    public function getUploadUrl(): string
    {
        return $this->upload_url;
    }

    /**
     * @param mixed $upload_url
     */
    public function setUploadUrl(string $upload_url): void
    {
        $this->upload_url = $upload_url;
    }

    /**
     * @return string
     */
    public function getFileList(): string
    {
        return $this->file_list;
    }

    /**
     * @param string $file_list
     */
    public function setFileList(string $file_list): void
    {
        $this->file_list = $file_list;
    }

    /**
     * @return string
     */
    public function getFileQuery(): string
    {
        return $this->file_query;
    }

    /**
     * @param string $file_query
     */
    public function setFileQuery(string $file_query): void
    {
        $this->file_query = $file_query;
    }

    /**
     * @return mixed
     */
    public function getDeleteUrl()
    {
        return $this->delete_url;
    }

    /**
     * @param mixed $delete_url
     */
    public function setDeleteUrl($delete_url): void
    {
        $this->delete_url = $delete_url;
    }
}

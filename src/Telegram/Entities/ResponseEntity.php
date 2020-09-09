<?php

namespace ZnSandbox\Telegram\Entities;

class ResponseEntity
{

    private $id = null;
    private $userId = null;
    private $message = null;
    private $media = null;
    private $file = null;
    private $replyMessageId = null;
    private $method = 'sendMessage';

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param null $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param null $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return null
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param null $media
     */
    public function setMedia($media): void
    {
        $this->media = $media;
    }

    /**
     * @return null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param null $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * @return null
     */
    public function getReplyMessageId()
    {
        return $this->replyMessageId;
    }

    /**
     * @param null $replyMessageId
     */
    public function setReplyMessageId($replyMessageId): void
    {
        $this->replyMessageId = $replyMessageId;
    }

    /**
     * @return null
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param null $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }

}
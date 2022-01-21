<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Dto;

class TotalDto
{

    protected $all = null;
    protected $new = null;
    protected $grabed = null;
    protected $parsed = null;

    /**
     * @return null
     */
    public function getAll()
    {
        return $this->all;
    }

    /**
     * @param null $all
     */
    public function setAll($all): void
    {
        $this->all = $all;
    }

    /**
     * @return null
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * @param null $new
     */
    public function setNew($new): void
    {
        $this->new = $new;
    }

    /**
     * @return null
     */
    public function getGrabed()
    {
        return $this->grabed;
    }

    /**
     * @param null $grabed
     */
    public function setGrabed($grabed): void
    {
        $this->grabed = $grabed;
    }

    /**
     * @return null
     */
    public function getParsed()
    {
        return $this->parsed;
    }

    /**
     * @param null $parsed
     */
    public function setParsed($parsed): void
    {
        $this->parsed = $parsed;
    }

}

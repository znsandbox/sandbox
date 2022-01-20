<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Dto;

class ListDto
{

    protected $pageCount = null;

    protected $links = null;

    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    public function setPageCount(int $pageCount): void
    {
        $this->pageCount = $pageCount;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function setLinks(array $links): void
    {
        $this->links = $links;
    }
}

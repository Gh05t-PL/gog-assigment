<?php

namespace App\DTO\Outcoming;

class PaginatedDTO implements OutcomingDTO
{
    private int $page;
    private int $perPage;
    private int $totalPages;
    private int $total;
    private array $data;

    public function __construct(
        int $page,
        int $perPage,
        int $totalPages,
        int $total,
        array $data
    ) {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->totalPages = $totalPages;
        $this->total = $total;
        $this->data = $data;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getData(): array
    {
        return $this->data;
    }
}

<?php

namespace Speccode\BestSellers\Application\Queries;

final class BestSellersQuery
{
    public function __construct(
        private ?string $title = null,
        private ?string $author = null,
        private ?array $isbns = null,
        private ?int $offset = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'author' => $this->author,
            'isbn' => $this->isbns ? implode(';', $this->isbns) : null,
            'offset' => $this->offset,
        ];
    }
}

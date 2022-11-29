<?php

namespace Speccode\BestSellers\Infrastructure\Repositories;

use Exception;
use Illuminate\Support\Facades\Http;
use Speccode\BestSellers\Application\Queries\BestSellersQuery;
use Speccode\BestSellers\Application\Repositories\BestSellersRepository;

class NycBestSellersRepository implements BestSellersRepository
{
    private string $url = 'https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json';

    public function __construct(
        private string $apiKey) {
    }

    public function getByQuery(BestSellersQuery $query): array
    {
        $respose = Http::get($this->url,
            $query->toArray() + ['api-key' => $this->apiKey],
        );

        if ($respose->status() === 429) {
            throw new Exception('Too many requests');
        }

        return $respose->json('results');
    }
}

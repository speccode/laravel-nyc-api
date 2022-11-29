<?php

namespace Speccode\BestSellers\Application\Repositories;

use Speccode\BestSellers\Application\Queries\BestSellersQuery;

interface BestSellersRepository
{
    public function getByQuery(BestSellersQuery $query): array;
}

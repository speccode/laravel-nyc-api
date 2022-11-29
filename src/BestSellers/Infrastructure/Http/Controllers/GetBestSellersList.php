<?php

namespace Speccode\BestSellers\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Speccode\BestSellers\Application\Repositories\BestSellersRepository;
use Speccode\BestSellers\Infrastructure\Http\Requests\GetBestSellersListRequest;

class GetBestSellersList extends Controller
{
    public function __construct(
        private BestSellersRepository $bestSellersRepository
    ) {
    }

    public function __invoke(GetBestSellersListRequest $request): array
    {
        //TODO: what fields do we actually need? We could create some DTO and actually write tests aginast structure
        //TODO: caching for bestSellers repository?
        //TODO: multiple ISBNs doesn't work even on NYC documentation page

        try {
            return $this->bestSellersRepository->getByQuery(
                $request->toBestSellersQuery()
            );
        } catch(Exception $e) {
            return [
                'error' => 'Results could not be loaded at given time.',
            ];
        }
    }
}

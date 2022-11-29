<?php

namespace Speccode\BestSellers\Infrastructure\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Speccode\BestSellers\Application\Queries\BestSellersQuery;

class GetBestSellersListRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string',
            'author' => 'sometimes|string',
            'isbn' => 'sometimes|array|min:1',
            'isbn.*' => [
                'sometimes',
                'numeric',
                'regex:/^\d{13}$|^\d{10}$/',
            ],
            'offset' => [
                'sometimes',
                'regex:/^\d{1,}$/',
                function (string $attribute, string $value, Closure $fail) {
                    $value = (int) $value;

                    if ($value % 20 > 0) {
                        $fail(sprintf('The %s is invalid', $attribute));
                    }
                },
            ],
        ];
    }

    public function toBestSellersQuery(): BestSellersQuery
    {
        return new BestSellersQuery(
            $this->json('title'),
            $this->json('author'),
            $this->json('isbn'),
            $this->json('offset'),
        );
    }
}

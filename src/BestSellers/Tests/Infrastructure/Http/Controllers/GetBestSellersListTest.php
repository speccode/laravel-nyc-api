<?php

namespace Speccode\BestSellers\Tests\Infrastructure\Http\Controllers;

use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Speccode\BestSellers\Application\Repositories\BestSellersRepository;
use Speccode\BestSellers\Tests\Infrastructure\RandomBookFactory;
use Tests\TestCase;

class GetBestSellersListTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->instance(
            BestSellersRepository::class,
            Mockery::mock(BestSellersRepository::class, function (MockInterface $mock) {
                $mock->shouldReceive('getByQuery');
            })
        );
    }

    public function provideInvalidIsbns(): array
    {
        return [
            'not enough numbers (9)' => [['123456789']],
            'not enough numbers (12)' => [['123456789012']],
            '13 letters' => [['foobarfoobarx']],
            '10 letters' => [['foobarfoba']],
            '10 mixed letters and numbers' => [['12foobar23']],
            'pair one valid, one invalid isbn' => [['1234567890', '121212121212']],
        ];
    }

    public function provideValidIsbns(): array
    {
        return [
            'pair of 10s' => [['1010101010', '2020202020']],
            'pair of 13s' => [['1313131313133', '2323232323233']],
            'pair of 10 and 13' => [['1010101010', '1313131313133']],
            'pair of 13 and 10' => [['1313131313133', '1010101010']],
        ];
    }

    public function provideInvalidOffsetValues(): array
    {
        return [
            'one' => ['1'],
            'eleven' => ['11'],
            'string' => ['foobar'],
            'string starting with number' => ['20foo'],
            'elite' => ['1337'],
        ];
    }

    /** @test */
    public function endpoint_is_reachable(): void
    {
        //given
        //when
        $response = $this->postJson(route('best-sellers'));

        //then
        $response->assertOk();
    }

    /** @test */
    public function returns_error_when_title_is_present_and_empty(): void
    {
        //given
        //when
        $response = $this->postJson(route('best-sellers'), [
            'title' => '',
        ]);

        //then
        $response->assertUnprocessable();
    }

    /** @test */
    public function returns_error_when_author_is_present_and_empty(): void
    {
        //given
        //when
        $response = $this->postJson(route('best-sellers'), [
            'author' => '',
        ]);

        //then
        $response->assertUnprocessable();
    }

    /** @test */
    public function returns_error_when_isbn_is_present_and_empty(): void
    {
        //given
        //when
        $response = $this->postJson(route('best-sellers'), [
            'isbn' => [],
        ]);

        //then
        $response->assertUnprocessable();
    }

    /**
     * @test
     * @dataProvider provideInvalidIsbns
     * @param string[] $invalidIsbns
     */
    public function returns_error_when_isbns_are_in_invalid_format(array $invalidIsbns): void
    {
        //given
        //when
        $response = $this->postJson(route('best-sellers'), [
            'isbn' => $invalidIsbns,
        ]);

        //then
        $response->assertUnprocessable();
    }

    /**
     * @test
     * @dataProvider provideValidIsbns
     * @param string[] $validIsbns
     */
    public function returns_ok_when_valid_isbns_provided(array $validIsbns): void
    {
        //given
        //when
        $response = $this->postJson(route('best-sellers'), [
            'isbn' => $validIsbns,
        ]);

        //then
        $response->assertOk();
    }

    /**
     * @test
     * @dataProvider provideInvalidOffsetValues
     */
    public function returns_error_when_offset_is_invalid(string $invalidOffset): void
    {
        $response = $this->postJson(route('best-sellers'), [
            'offset' => $invalidOffset,
        ]);

        //then
        $response->assertUnprocessable();
    }
}

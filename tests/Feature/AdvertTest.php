<?php

namespace Tests\Feature;

use App\Models\Advert;
use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Concerns\TestDatabases;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use function PHPUnit\Framework\assertTrue;

class AdvertTest extends TestCase
{
    use TestDatabases, RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index_route_returns_collection(): void
    {
        Advert::factory()->count(10)->create();

        $response = $this->get('/api/adverts');

        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }

    public function test_index_route_returns_collection_with_required_fields()
    {
        Advert::factory()->has(Photo::factory()->count(rand(1, 3)))->count(10)->create();

        $response = $this->get('/api/adverts');

        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'title',
                    'price',
                    'photo',
                ]
            ]
        ]);
    }

    public function test_index_collection_has_option_to_be_sorted_by_price()
    {
        $count = rand(2, 10);
        Advert::factory()->count($count)->create();
        $response = $this->get('/api/adverts/price/asc');

        $jsonData = $response->json()['data'];

        $i = $count;
        while ($i - 1 > 0) {
            assertTrue(current($jsonData)['price'] < (next($jsonData)['price'] ?? end($jsonData)['price']));
            $i--;
        }
    }

    public function test_advert_has_required_fields()
    {
        $ad = Advert::factory()->has(Photo::factory()->count(rand(1, 3)))->create();

        $response = $this->getJson('/api/adverts/' . $ad->id);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'price',
                'photo',
            ]
        ]);
    }

    public function test_advert_has_optional_fields()
    {
        $ad = Advert::factory()->has(Photo::factory()->count(rand(1, 3)))->create();

        $response = $this->getJson('/api/adverts/' . $ad->id . '?fields=text,allphotos');

        $response->assertJson(fn(AssertableJson $json) =>
            $json->has('data')->first(fn (AssertableJson $json) =>
                $json->where('id', $ad->id)
                    ->hasAll(['text', 'allphotos'])
                    ->etc()
            )
        );
    }

    public function test_advert_with_photo_can_be_created()
    {
        $correctAd = Advert::factory()->make();
        $adWithPhoto = Advert::factory()->withPhotos(3)->make();
        $incorrectAd = Advert::factory()->withPhotos(6)->make();

        $success = $this->postJson('api/adverts', $correctAd->toArray());
        $successWithPhoto = $this->postJson('api/adverts', $adWithPhoto->toArray());
        $failure = $this->postJson('api/adverts', $incorrectAd->toArray());

        $success->assertStatus(201);
        $successWithPhoto->assertStatus(201);
        $failure->assertStatus(422);

        $this->assertDatabaseHas('adverts', [
            'title' => $correctAd->title,
            'text' => $correctAd->text,
            'price' => $correctAd->price
        ]);

        $this->assertDatabaseHas('adverts', [
            'title' => $adWithPhoto->title,
            'text' => $adWithPhoto->text,
            'price' => $adWithPhoto->price
        ]);

        $this->assertDatabaseMissing('adverts', [
            'title' => $incorrectAd->title,
            'text' => $incorrectAd->text,
            'price' => $incorrectAd->price
        ]);
    }
}

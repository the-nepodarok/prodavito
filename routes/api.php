<?php

use App\Http\Controllers\AdvertController;
use App\Http\Resources\AdvertResource;
use App\Models\Advert;
use Illuminate\Support\Facades\Route;

// Адрес для получения списка всех объявлений. Предоставляет возможность указать поле для сортировки и направление сортировки
Route::get('/adverts/{order?}/{dir?}', function (string $order, string $dir) {
    return AdvertResource::collection(Advert::query()->with('photos')->orderBy($order, $dir)->paginate(10));
})->whereIn('order', ['date', 'price'])->whereIn('dir', ['desc', 'asc'])->setDefaults([
    'order' => 'date',
    'dir' => 'desc'
]);


// Адрес для получения одного объявления по его ID. Позволяет указать дополнительные поля text и photos
Route::get('/adverts/{id}', function (string $id) {
    return new AdvertResource(Advert::query()->findOrFail($id));
})->whereNumber('id')->whereIn('fields', ['text', 'photos']);

// Адрес для создания нового объявления
Route::post('/adverts', [AdvertController::class, 'store']);

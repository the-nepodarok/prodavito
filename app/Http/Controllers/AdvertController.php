<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvertFormRequest;
use App\Models\Advert;
use Illuminate\Http\JsonResponse;

class AdvertController extends Controller
{
    /**
     * Создаёт новую запись с привязкой ссылок фотографий
     * @param AdvertFormRequest $request
     * @return JsonResponse ID созданного объявления и код результата (ошибка или успех)
     */
    public function store(AdvertFormRequest $request): JsonResponse
    {
        $postData = $request->validated();

        try {
            $advert = Advert::create($postData);

            if (isset($postData['photos'])) {
                // разбиение ссылок на фото по пробелам или запятым
                $photos = preg_split('/[\s,]/', $postData['photos']);

                // прикрепление фото к объявению
                foreach ($photos as $photo) {
                    $advert->photos()->create([
                        'photo_url' => $photo
                    ]);
                }
            }
        } catch (\Exception $exception) {
            $failure = response()->json($exception->getMessage(), 500);
        }

        return $failure ?? response()->json(['id' => $advert->id], 201);
    }
}

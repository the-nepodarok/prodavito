<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array <string, mixed>
     */
    public function toArray(Request $request): array
    {
        // определить дополнительные поля из запроса
        $extraFields = explode(',', $request->query('fields'));
        $merge = [];

        foreach ($extraFields as $field) {
            $merge[$field] = $this->getAttribute($field);
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'photo' => $this->firstPhoto?->photo_url,
            'photos_count' => $this->photos()->count(),

            // добавить в структуру ответа дополнительные поля
            $this->mergeWhen($request->query('fields'), $merge),
        ];
    }
}

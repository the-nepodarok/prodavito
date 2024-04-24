<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Advert extends Model
{
    use HasFactory;

    // переопределение дефолтных timestamp'ов
    const CREATED_AT = 'date';
    const UPDATED_AT = null;

    protected $fillable = [
        'title',
        'text',
        'price',
    ];

    /**
     * Метод записывает в атрибут модели первое фото объявления
     * @return Model|null
     */
    public function getFirstPhotoAttribute(): Model|null
    {
        return $this->photos()->orderBy('id')->first();
    }

    /**
     * Метод записывает в атрибут модели массив из всех ссылок связанных с объявлением фотографий
     * @return \Illuminate\Support\Collection
     */
    public function getAllPhotosAttribute(): \Illuminate\Support\Collection
    {
        return $this->photos()->pluck('photo_url');
    }

    /**
     * Связь с таблицей фотографий
     * @return HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }
}

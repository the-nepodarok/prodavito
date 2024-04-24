<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('photo_url');
            $table->foreignId('advert_id')->references('id')->on('adverts')->cascadeOnDelete();
        });

        $photos = [
            [
                'photo_url' => 'https://4pda.to/s/as6yz1eCQM6JXcB77z1ez0z23nSfjM7z0ya7V6Bz1lWAHAD90I.jpg',
                'advert_id' => 1,
            ], [
                'photo_url' => 'https://www.vopmart.com/media/wysiwyg/Huawei/huawei-pura-70-ultra-review-02.jpg',
                'advert_id' => 1,
            ], [], [
                'photo_url' => 'https://www.notebookcheck.net/fileadmin/_processed_/a/8/csm_9c780f15ly1hn8xjfuipxj212y11fdpx_e22b7ddc00.jpg',
                'advert_id' => 1,
            ], [
                'photo_url' => 'https://lifehacker.ru/wp-content/uploads/2024/02/2024-02-09-21.59.09_1707505178.jpg',
                'advert_id' => 2
            ]
        ];

        foreach ($photos as $photo) {
            DB::table('photos')->insert($photo);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};

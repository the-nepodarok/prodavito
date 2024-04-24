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
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('text');
            $table->integer('price')->nullable();
            $table->dateTime('date')->default(DB::raw('NOW()'));
        });

        $ads = [
            [
                'id' => 1,
                'title' => 'Huawei P90 Pro Ultra',
                'text' => 'Новый, заказан в Китае в день старта продаж',
                'price' => 90000,
                'date' => '2024-04-24 22:22:00'
            ], [
                'id' => 2,
                'title' => 'Sony Playstation 6',
                'text' => 'На корпусе есть царапины.',
                'price' => 130000,
                'date' => '2024-04-22 22:22:00'
            ]
        ];

        foreach ($ads as $ad) {
            DB::table('adverts')->insert($ad);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adverts');
    }
};

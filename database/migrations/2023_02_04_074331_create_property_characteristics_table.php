<?php

use App\Enums\PropertyStatusEnum;
use App\Enums\PropertyTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_characteristics', function (Blueprint $table) {
            $table->foreignId('property_id')->unique()->constrained()->cascadeOnDelete();
            $table->float('price');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->float('sqft');
            $table->float('price_sqft');
            $table->enum('property_type', [
                PropertyTypeEnum::SINGLE->value,
                PropertyTypeEnum::TOWNHOUSE->value,
                PropertyTypeEnum::MULTIFAMILY->value,
                PropertyTypeEnum::BUNGALOW->value,
            ])->default(PropertyTypeEnum::SINGLE->value);

            $table->enum('status', [
                PropertyStatusEnum::SOLD->value,
                PropertyStatusEnum::HOLD->value,
                PropertyStatusEnum::SALE->value,
            ])->default(PropertyStatusEnum::SALE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_characteristics');
    }
};

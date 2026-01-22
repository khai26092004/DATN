<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('characteristics')->nullable()->after('description');
            $table->text('light')->nullable()->after('characteristics');
            $table->text('watering')->nullable()->after('light');
            $table->text('usage')->nullable()->after('watering');
            $table->text('meaning')->nullable()->after('usage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Prevent duplicate pairs
            $table->unique(['product_id', 'category_id']);
        });

        // Migrate existing data from products.category_id to pivot table
        // Use try-catch or check if column exists to be safe, but we know it does from previous steps
        $products = DB::table('products')->whereNotNull('category_id')->get();
        foreach ($products as $product) {
            DB::table('category_product')->insert([
                'product_id' => $product->id,
                'category_id' => $product->category_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Remove the old foreign key and column
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key first. Convention: table_column_foreign
            // Since we are not sure if the constraint name is standard, let's try dropping by column name if the driver supports it or use the standard name.
            // Laravel's dropForeign(['column']) computes the name 'table_column_foreign'.
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add the column back
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
        });

        // Restore data (take the first category found)
        $pivots = DB::table('category_product')->get();
        foreach ($pivots as $pivot) {
            DB::table('products')
                ->where('id', $pivot->product_id)
                ->update(['category_id' => $pivot->category_id]);
        }

        Schema::dropIfExists('category_product');
    }
};
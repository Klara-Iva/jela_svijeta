<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */


     public function up(): void
     {
        
 // Categories
 Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('slug')->unique();
    $table->timestamps();
});

Schema::create('category_translations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->string('locale')->index();
    $table->string('title');
    $table->unique(['category_id', 'locale']);
});

// Tags
Schema::create('tags', function (Blueprint $table) {
    $table->id();
    $table->string('slug')->unique();
    $table->timestamps();
});

Schema::create('tag_translations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tag_id')->constrained()->onDelete('cascade');
    $table->string('locale')->index();
    $table->string('title');
    $table->unique(['tag_id', 'locale']);
});

// Ingredients
Schema::create('ingredients', function (Blueprint $table) {
    $table->id();
    $table->string('slug')->unique();
    $table->timestamps();
});

Schema::create('ingredient_translations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
    $table->string('locale')->index();
    $table->string('title');
    $table->unique(['ingredient_id', 'locale']);
});

// Dishes
Schema::create('dishes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
    $table->string('status')->default('created');
    $table->timestamps();
    $table->softDeletes();
});

Schema::create('dish_translations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('dish_id')->constrained()->onDelete('cascade');
    $table->string('locale')->index();
    $table->string('title');
    $table->text('description');
    $table->unique(['dish_id', 'locale']);
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('dish_translations');
Schema::dropIfExists('dishes');
Schema::dropIfExists('ingredient_translations');
Schema::dropIfExists('ingredients');
Schema::dropIfExists('tag_translations');
Schema::dropIfExists('tags');
Schema::dropIfExists('category_translations');
Schema::dropIfExists('categories');
}
};

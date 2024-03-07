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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('AVAILABLE')->comment('Book availability status');
            $table->string('title');
            $table->string('author');
            $table->date('publication_date');
            $table->string('publishing_house');
            $table->foreignId('customer_id')
                ->nullable()
                ->default(null)
                ->constrained('customers')
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

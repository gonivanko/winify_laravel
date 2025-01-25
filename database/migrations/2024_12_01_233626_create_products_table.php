<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bidder_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('title');
            $table->longText('description');

            $table->integer('min_bid');
            $table->integer('bid_step');

            $table->integer('current_bid')->nullable();

            $table->boolean('is_paid')->default(0);
            $table->boolean('is_received')->default(0);
            
            $table->string('location');
            $table->enum('condition', ['new', 'used']);

            $table->timestamp('starting_datetime');
            $table->timestamp('ending_datetime');

            $table->string('photo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints(); // Disable foreign key checks
        Schema::dropIfExists('products');
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();  // Re-enable foreign key checks
    }

};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete();

            $table->date('start_date');
            $table->date('end_date');

            $table->string('status')
                ->default('active'); 
            // active, inactive, trial, isolir, dismantle

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
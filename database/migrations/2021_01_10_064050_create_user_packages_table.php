<?php

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
        Schema::create('user_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->foreignId('departure_id')->constrained('package_departures')->cascadeOnDelete();
            $table->integer('number_of_trekkers');
            $table->string('trek_group')->default('group');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->boolean('is_paid')->default(false);
            $table->string('payment_status')->default('pending');
            $table->date('arrival_date')->nullable();
            $table->time('arrival_time')->nullable();
            $table->string('flight_number')->nullable();
            $table->enum('airport_pickup', ['Yes', 'No'])->default('No');
            $table->json('group_dates')->nullable();
            $table->text('special_instructions')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('emergency_email')->nullable();
            $table->boolean('send_review_email')->default(true);
            $table->date('appointment_date')->nullable();
            $table->time('appointment_time')->nullable();
            $table->string('meeting_location')->nullable();
            $table->string('hotel_name')->nullable();
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
        Schema::dropIfExists('user_packages');
    }
};

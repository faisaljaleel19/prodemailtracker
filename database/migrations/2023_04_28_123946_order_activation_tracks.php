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
        Schema::create('order_activation_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 400)->nullable();
            $table->date('order_punched_date')->nullable();
            $table->date('order_confirmed_date')->nullable();
            $table->string('student_name', 800)->nullable();
            $table->string('primary_email_id', 800)->nullable();
            $table->string('primary_mobile_no', 800)->nullable();
            $table->string('oh_number', 800)->nullable();
            $table->string('premium_id', 800)->nullable();
            $table->string('sales_user', 800)->nullable();
            $table->text('lead_details')->nullable();
            $table->string('category', 800)->nullable();
            $table->string('syllabus', 800)->nullable();
            $table->string('activation_status', 800)->nullable();
            $table->string('delivered_marked', 800)->nullable();
            $table->string('mail_sent', 800)->nullable();
            $table->date('lead_sent_to_india_date')->nullable();
            $table->string('task_creation_sent_to_india', 800)->nullable();
            $table->text('remarks')->nullable();
            $table->string('manually_link_sent_to_india', 800)->nullable();
            $table->string('batch_no', 800)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_activation_tracks');
    }
};

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
        Schema::create('gt_trainees', function (Blueprint $table) {
            $table->bigIncrements('id')->from(2423);
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('gt_users');
            $table->bigInteger('follow_up')->unsigned()->nullable();
            $table->foreign('follow_up')->references('id')->on('gt_users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('trainer_id')->unsigned()->nullable();
            $table->foreign('trainer_id')->references('id')->on('gt_users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('gt_branches')->onUpdate('cascade')->onDelete('cascade');
            $table->string('full_name');
            $table->text('notes');
            $table->enum('attend_type', ['Online', 'Offline', 'Hybrid']);
            $table->bigInteger('level')->unsigned()->nullable();
            $table->foreign('level')->references('id')->on('gt_generalmeta')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('payment_type')->unsigned()->nullable();
            $table->foreign('payment_type')->references('id')->on('gt_generalmeta')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('current_list')->unsigned()->nullable();
            $table->foreign('current_list')->references('id')->on('gt_lists')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('pervious_list')->unsigned()->nullable();
            $table->foreign('pervious_list')->references('id')->on('gt_lists')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gt_trainees');
    }
};

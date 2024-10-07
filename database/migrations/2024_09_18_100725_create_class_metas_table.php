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
        Schema::create('gt_classmeta', function (Blueprint $table) {
            $table->bigIncrements('id')->from(2423);
            $table->bigInteger('class_id')->unsigned();
            $table->foreign('class_id')->references('id')->on('gt_classes')->onDelete('cascade');
            $table->string('meta_key');
            $table->text('meta_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gt_classmeta');
    }
};

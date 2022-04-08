<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_entries', function (Blueprint $table) {
            $table->uuid('id')->unique()->index();
            $table->uuid('employeeId')->index();
            $table->timestamp('startDate');
            $table->timestamp('endDate')->nullable();
            $table->timestamp('createdAt');
            $table->timestamp('updatedAt');
            $table->timestamp('deletedAt')->nullable();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('work_entries');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // make start_date, status, priority and risk_level nullable
        Schema::table('goals', function (Blueprint $table) {
            $table->date('start_date')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('priority')->nullable()->change();
            $table->string('risk_level')->nullable()->change();
            $table->string('progress')->nullable()->change();
        });
    }
};

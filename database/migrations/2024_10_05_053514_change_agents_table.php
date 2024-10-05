<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            // remove foreign agents_team_id_foreign and drop team_id column
            $table->dropForeign('agents_team_id_foreign');
            $table->dropColumn('team_id');
        });
    }
};

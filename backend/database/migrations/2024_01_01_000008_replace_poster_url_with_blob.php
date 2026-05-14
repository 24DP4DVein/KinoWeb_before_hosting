<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('poster_url');
            $table->string('poster_mime', 100)->nullable()->after('posterGradient');
        });

        DB::statement('ALTER TABLE movies ADD COLUMN poster_data LONGBLOB NULL AFTER poster_mime');
    }

    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['poster_mime', 'poster_data']);
            $table->string('poster_url')->nullable()->after('posterGradient');
        });
    }
};

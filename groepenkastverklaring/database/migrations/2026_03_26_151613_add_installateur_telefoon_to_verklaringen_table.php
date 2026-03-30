<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('verklaringen', function (Blueprint $table) {
            $table->string('installateur_telefoon')->nullable()->after('installateur');
        });
    }

    public function down(): void
    {
        Schema::table('verklaringen', function (Blueprint $table) {
            $table->dropColumn('installateur_telefoon');
        });
    }
};

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
        Schema::table('wanted_items', function (Blueprint $table) {
            $table->boolean('is_fulfilled')->default(false)->after('description');
            $table->string('offer_type')->nullable()->after('is_fulfilled'); 
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wanted_items', function (Blueprint $table) {
            //
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            if (!Schema::hasColumn('materials', 'whatsapp_number')) {
                $table->string('whatsapp_number')->nullable()->after('file_path');
            }
            
            if (!Schema::hasColumn('materials', 'type')) {
                $table->string('type')->default('pdf')->after('whatsapp_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            if (Schema::hasColumn('materials', 'whatsapp_number')) {
                $table->dropColumn('whatsapp_number');
            }
            if (Schema::hasColumn('materials', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
    
};

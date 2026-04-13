<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function markAsSold(Request $request, $id) {
    $material = Material::where('id', $id)
                        ->where('user_id', $request->user()->id)
                        ->firstOrFail();

    $material->update(['is_available' => false]);

    return response()->json(['message' => 'تم تحديث حالة المادة بنجاح']);
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            //
        });
    }
};

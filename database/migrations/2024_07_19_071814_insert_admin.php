<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('dtb_admin')->insert([
            [
                'id' => 1,
                'name' => 'テスト鳥居',
                'email' => 'test@example.com',
                'password' => Hash::make('testtest'),
                'icon' => 'img/test.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('dtb_admin')->where('id', 1)->delete();
    }
};

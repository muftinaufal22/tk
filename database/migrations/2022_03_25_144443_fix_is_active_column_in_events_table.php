<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixIsActiveColumnInEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // Hapus kolom is_active yang lama
            $table->dropColumn('is_active');
        });
        
        Schema::table('events', function (Blueprint $table) {
            // Tambah kolom is_active yang baru dengan tipe yang benar
            $table->tinyInteger('is_active')->default(0)->comment('0=Aktif, 1=Tidak Aktif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        
        Schema::table('events', function (Blueprint $table) {
            $table->enum('is_active', [0, 1])->default(0);
        });
    }
}
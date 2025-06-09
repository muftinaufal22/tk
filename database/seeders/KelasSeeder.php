<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run()
    {
        Kelas::create(['nama' => 'Kelas A']);
        Kelas::create(['nama' => 'Kelas B']);
    }
}

<?php

use App\Gudang;
use App\Sampah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sampah = Sampah::all();

        $sampah->each(function($item) {
            Gudang::create([ 'sampah_id' => $item->id ]);;
        });
    }
}

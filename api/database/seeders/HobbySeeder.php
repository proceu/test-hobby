<?php

namespace Database\Seeders;

use App\Models\HobbyCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $file = Storage::get('private/i_sport_en.csv');
        $lines = explode("\r\n",$file);
        foreach($lines as $line) {
            $item = explode(',',$line);
            $category = HobbyCategory::firstOrCreate(['name' => trim($item[1])]);
            $category->hobbies()->firstOrCreate(['name' => trim($item[0])]);
        }
    }
}

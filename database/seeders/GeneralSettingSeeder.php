<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GeneralSetting::create([
            'name' => "Firebase Key",
            'type' => 'configuration',
            'key' => 'firebase_key',
            'value' => "",
        ]);
    }
}

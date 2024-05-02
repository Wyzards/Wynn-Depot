<?php

namespace Database\Seeders;

use App\Models\WynnItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class WynnItemSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $items = Http::get("https://api.wynncraft.com/v3/item/database?fullResult");

        dd($items);
    }
}

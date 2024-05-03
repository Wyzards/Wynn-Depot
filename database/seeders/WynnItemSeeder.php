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
        $items = Http::get("https://api.wynncraft.com/v3/item/database?fullResult")->json();

        foreach ($items as $name => $item)
        {
            if (!array_key_exists("type", $item) && !array_key_exists("accessoryType", $item))
            {
                continue;
            }

            WynnItem::updateOrCreate(
                [
                    'internal_name' => $item["internalName"]
                ],
                [
                    'name' => $name,
                    'level' => $item["requirements"]["level"],
                    'tier' => $item["tier"],
                    'type' => array_key_exists("type", $item) ? $item["type"] : $item["accessoryType"]
                ]
            );
        }
    }
}

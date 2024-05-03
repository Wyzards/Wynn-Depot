<?php

use App\Models\WynnItem;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'items' => WynnItem::filter(request(['search', 'tier', 'type']))->paginate(20),
        'filters' => Request::only(['search', 'tier', 'type'])
    ]);
});

Route::post('/items', function () {
    $item = WynnItem::find(request('item_id'));
    $item->image = request()->hasFile('item_image') ? request()->file('item_image')->store('screenshots') : null;
    $item->save();
});

require __DIR__ . '/auth.php';

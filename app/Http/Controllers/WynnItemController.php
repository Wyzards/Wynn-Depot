<?php

namespace App\Http\Controllers;

use App\Models\WynnItem;
use Inertia\Inertia;

class WynnItemController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'items' => WynnItem::filter(request(['search', 'tier', 'type', 'minLevel', 'maxLevel', 'misc', 'storage']))->orderBy(request('sortBy') ?? 'name', request('sortDirection') ?? 'asc')->paginate(20)->withQueryString(),
            'storageOptions' => array_values(WynnItem::all()->unique('storage')->map(fn($item) => $item->storage)->filter(fn($storageValue) => $storageValue !== null)->toArray())
        ]);
    }

    public function update(WynnItem $item)
    {
        $attributes = request()->validate([
            'percent' => 'numeric|min:0|max:100|nullable',
            'storage' => 'nullable',
            'notes' => 'nullable',
            'screenshot' => 'image|nullable|sometimes'
        ]);

        $item->percent = $attributes['percent'];
        $item->storage = $attributes['storage'];
        $item->notes = $attributes['notes'];
        $item->image = $attributes['screenshot'] ?? false ? request()->file('screenshot')->store('screenshots') : null;

        $item->save();

        return back();
    }
}

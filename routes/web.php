<?php
use App\Models\WynnItem;
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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';

<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WynnItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFilter($query, array $filters): void
    {
        $query->when(
            $filters['misc'] ?? false,
            function (Builder $query, array $misc) {
                $query->when(
                    in_array('owned', $misc),
                    fn(Builder $query, $owned) => $query->where(
                        fn($query) => $query
                            ->whereNotNull('percent')
                            ->orWhereNotNull('image')
                    )
                );

                $query->when(
                    in_array('not owned', $misc),
                    fn(Builder $query, $notOwned) => $query
                        ->whereNull('percent')
                        ->whereNull('image')
                );

                $query->when(
                    in_array('untradable', $misc),
                    fn(Builder $query, $untradable) => $query
                        ->where('restrictions', '=', 'untradable')
                );

                $query->when(
                    in_array('quest item', $misc),
                    fn(Builder $query, $untradable) => $query
                        ->where('restrictions', '=', 'quest item')
                );
            }
        );


        $query->when($filters['minLevel'] ?? false, fn($query, $minLevel) => $query
            ->where('level', '>=', $minLevel));
        $query->when($filters['maxLevel'] ?? false, fn($query, $maxLevel) => $query
            ->where('level', '<=', $maxLevel));

        $query->when($filters['type'] ?? false, fn($query, $type) => $query->whereIn('type', $type));

        $query->when($filters['storage'] ?? false, fn($query, $storage) => $query->whereIn('storage', $storage));

        $query->when($filters['tier'] ?? false, fn($query, $tier) => $query->whereIn('tier', $tier));

        $query->when(
            $filters['search'] ?? false,
            fn($query, $search) => $query->where(
                fn($query) => $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('internal_name', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%")
            )
        );
    }
}

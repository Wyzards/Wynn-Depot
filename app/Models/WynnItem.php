<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WynnItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['type'] ?? false, fn($query, $type) => $query->whereIn('type', $type));

        $query->when($filters['tier'] ?? false, fn($query, $tier) => $query->whereIn('tier', $tier));

        $query->when($filters['search'] ?? false, fn($query, $search) => $query->where(fn($query) => $query
            ->where('name', 'like', "%{$search}%")
            ->orWhere('internal_name', 'like', "%{$search}%")));
    }
}

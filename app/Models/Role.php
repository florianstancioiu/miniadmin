<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug'
    ];

    public function scopeSearch($query, $keyword)
    {
        return $query
            ->whereRaw('LOWER(`title`) LIKE ? ', ['%' . strtolower($keyword) .'%'])
            ->orWhereRaw('LOWER(`slug`) LIKE ? ', ['%' . strtolower($keyword) .'%']);
    }
}

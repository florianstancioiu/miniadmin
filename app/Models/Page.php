<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        return url('storage/'. $this->image);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query
            ->whereRaw('LOWER(`title`) LIKE ? ', ['%' . strtolower($keyword) .'%'])
            ->orWhereRaw('LOWER(`content`) LIKE ? ', ['%' . strtolower($keyword) .'%']);
    }
}

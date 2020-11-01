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

    public function getImageUrlAttribute()
    {
        return url('storage/'. $this->image);
    }
}

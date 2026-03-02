<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'content',
        'status',
    ];

    /**
     * Auto-generate slug from name if not provided.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($template) {
            if (empty($template->slug)) {
                $template->slug = Str::slug($template->name);
            }
        });
    }
}

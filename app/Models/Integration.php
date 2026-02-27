<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    use HasFactory;

    protected $table = 'integrations'; // Table name

    protected $fillable = ['name', 'slug', 'type', 'description'];

    public function userIntegrations()
    {
        return $this->hasMany(UserIntegration::class);
    }
}
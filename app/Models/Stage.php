<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id', 'register_start', 'register_end',
        'race_start', 'title', 'excerpt',
        'description', 'status'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function races()
    {
        return $this->hasMany(Race::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

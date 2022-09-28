<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage_id', 'number',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function stages()
    {
        return $this->belongsTo(Stage::class);
    }
}

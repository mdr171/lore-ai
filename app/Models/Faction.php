<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    use HasFactory;

    protected $fillable = [
        'novel_id',
        'name',
        'type',
        'description',
        'alignment',
    ];

    public function novel()
    {
        return $this->belongsTo(Novel::class);
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}

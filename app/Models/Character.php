<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'novel_id',
        'faction_id',
        'name',
        'cultivation_realm',
        'role',
        'description',
        'status',
    ];

    public function novel()
    {
        return $this->belongsTo(Novel::class);
    }

    public function faction()
    {
        return $this->belongsTo(Faction::class);
    }

    public function chapters()
    {
        return $this->belongsToMany(Chapter::class, 'chapter_character');
    }

    public function relationships()
    {
        return $this->hasMany(Relationship::class, 'source_character_id');
    }

    public function targetRelationships()
    {
        return $this->hasMany(Relationship::class, 'target_character_id');
    }
}

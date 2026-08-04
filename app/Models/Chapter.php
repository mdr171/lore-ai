<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'novel_id',
        'chapter_number',
        'title',
        'content',
        'summary',
        'lore_extracted',
        'status',
    ];

    public function novel()
    {
        return $this->belongsTo(Novel::class);
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'chapter_character');
    }

    public function relationships()
    {
        return $this->hasMany(Relationship::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_id',
        'source_character_id',
        'target_character_id',
        'relation_type',
        'notes',
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function sourceCharacter()
    {
        return $this->belongsTo(Character::class, 'source_character_id');
    }

    public function targetCharacter()
    {
        return $this->belongsTo(Character::class, 'target_character_id');
    }
}

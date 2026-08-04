<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Character;
use App\Models\Faction;
use App\Models\Novel;
use App\Models\Relationship;
use Illuminate\Http\Request;

class LoreApiController extends Controller
{
    public function novels()
    {
        $novels = Novel::withCount(['chapters', 'characters', 'factions'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $novels,
        ]);
    }

    public function characters($id)
    {
        $characters = Character::where('novel_id', $id)
            ->with('faction')
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => $characters->count(),
            'data' => $characters,
        ]);
    }

    public function factions($id)
    {
        $factions = Faction::where('novel_id', $id)
            ->withCount('characters')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $factions,
        ]);
    }

    public function relationships($id)
    {
        $novel = Novel::findOrFail($id);
        $chapterIds = $novel->chapters()->pluck('id');

        $relationships = Relationship::whereIn('chapter_id', $chapterIds)
            ->with(['sourceCharacter', 'targetCharacter'])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $relationships,
        ]);
    }

    public function chapterDetail($id)
    {
        $chapter = Chapter::with(['novel', 'characters.faction', 'relationships.sourceCharacter', 'relationships.targetCharacter'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $chapter->id,
                'novel' => $chapter->novel->title,
                'chapter_number' => $chapter->chapter_number,
                'title' => $chapter->title,
                'status' => $chapter->status,
                'summary' => $chapter->summary,
                'characters' => $chapter->characters,
                'relationships' => $chapter->relationships,
                'lore_extracted' => json_decode($chapter->lore_extracted, true),
            ]
        ]);
    }
}

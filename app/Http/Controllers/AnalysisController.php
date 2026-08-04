<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Character;
use App\Models\Faction;
use App\Models\Relationship;
use App\Services\DeepseekService;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    protected $deepseek;

    public function __construct(DeepseekService $deepseek)
    {
        $this->deepseek = $deepseek;
    }

    public function analyze(Chapter $chapter)
    {
        $chapter->update(['status' => 'processing']);

        try {
            $result = $this->deepseek->analyzeChapter($chapter->content, $chapter->title);

            if (!$result || !isset($result['characters'])) {
                $chapter->update(['status' => 'failed']);
                return back()->with('error', 'Failed to extract lore from DeepSeek response.');
            }

            // Process Factions first
            $factionMap = [];
            if (!empty($result['factions'])) {
                foreach ($result['factions'] as $f) {
                    $faction = Faction::firstOrCreate(
                        ['name' => $f['name'], 'novel_id' => $chapter->novel_id],
                        [
                            'type' => $f['type'] ?? 'Sect',
                            'description' => $f['description'] ?? null,
                            'alignment' => $f['alignment'] ?? 'Neutral',
                        ]
                    );
                    $factionMap[$f['name']] = $faction->id;
                }
            }

            // Process Characters
            $charMap = [];
            if (!empty($result['characters'])) {
                foreach ($result['characters'] as $c) {
                    $factionId = isset($c['faction']) && isset($factionMap[$c['faction']])
                        ? $factionMap[$c['faction']]
                        : null;

                    $character = Character::updateOrCreate(
                        ['name' => $c['name'], 'novel_id' => $chapter->novel_id],
                        [
                            'faction_id' => $factionId,
                            'cultivation_realm' => $c['realm'] ?? 'Unknown',
                            'role' => $c['role'] ?? 'Background Character',
                            'description' => $c['summary'] ?? null,
                            'status' => $c['status'] ?? 'Alive',
                        ]
                    );

                    $charMap[$c['name']] = $character->id;
                    $chapter->characters()->syncWithoutDetaching([$character->id]);
                }
            }

            // Process Relationships
            if (!empty($result['relationships'])) {
                foreach ($result['relationships'] as $rel) {
                    $sourceId = $charMap[$rel['source']] ?? null;
                    $targetId = $charMap[$rel['target']] ?? null;

                    if ($sourceId && $targetId) {
                        Relationship::updateOrCreate([
                            'chapter_id' => $chapter->id,
                            'source_character_id' => $sourceId,
                            'target_character_id' => $targetId,
                        ], [
                            'relation_type' => $rel['type'] ?? 'Acquaintance',
                            'notes' => $rel['notes'] ?? null,
                        ]);
                    }
                }
            }

            $chapter->update([
                'status' => 'completed',
                'summary' => $result['chapter_summary'] ?? 'No summary generated.',
                'lore_extracted' => json_encode($result['lore_items'] ?? []),
            ]);

            return redirect()->route('analysis.results', $chapter->id)
                ->with('success', 'Lore analysis finished successfully!');

        } catch (\Exception $e) {
            $chapter->update(['status' => 'failed']);
            return back()->with('error', 'Error during Deepseek API call: ' . $e->getMessage());
        }
    }

    public function results(Chapter $chapter)
    {
        $chapter->load(['novel', 'characters.faction', 'relationships.sourceCharacter', 'relationships.targetCharacter']);
        $loreItems = json_decode($chapter->lore_extracted, true) ?? [];

        return view('analysis.results', compact('chapter', 'loreItems'));
    }
}

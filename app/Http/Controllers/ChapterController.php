<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Character;
use App\Models\Faction;
use App\Models\Novel;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_novels' => Novel::count(),
            'total_chapters' => Chapter::count(),
            'total_characters' => Character::count(),
            'total_factions' => Faction::count(),
        ];

        $recentChapters = Chapter::with('novel')
            ->latest()
            ->take(5)
            ->get();

        $topCharacters = Character::withCount('relationships')
            ->orderBy('relationships_count', 'desc')
            ->take(6)
            ->get();

        return view('dashboard', compact('stats', 'recentChapters', 'topCharacters'));
    }

    public function index(Request $request)
    {
        $query = Chapter::with('novel')->latest();

        if ($request->has('novel_id')) {
            $query->where('novel_id', $request->novel_id);
        }

        $chapters = $query->paginate(10);
        $novels = Novel::all();

        return view('chapters.index', compact('chapters', 'novels'));
    }

    public function create()
    {
        $novels = Novel::all();
        return view('chapters.create', compact('novels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'novel_name' => 'nullable|string|max:255',
            'novel_id' => 'nullable|exists:novels,id',
            'chapter_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:50',
        ]);

        if (empty($validated['novel_id'])) {
            $novel = Novel::firstOrCreate([
                'title' => $validated['novel_name'] ?? 'Untitled Xianxia Novel',
            ], [
                'author' => 'Unknown Author',
                'description' => 'Auto-created novel for chapter analysis.',
            ]);
            $novelId = $novel->id;
        } else {
            $novelId = $validated['novel_id'];
        }

        $chapter = Chapter::create([
            'novel_id' => $novelId,
            'chapter_number' => $validated['chapter_number'],
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => 'pending',
        ]);

        return redirect()->route('chapters.show', $chapter->id)
            ->with('success', 'Chapter pasted successfully! Ready for AI analysis.');
    }

    public function show(Chapter $chapter)
    {
        $chapter->load(['novel', 'characters.faction', 'relationships']);
        return view('chapters.show', compact('chapter'));
    }

    public function destroy(Chapter $chapter)
    {
        $chapter->delete();
        return redirect()->route('chapters.index')->with('success', 'Chapter deleted.');
    }
}

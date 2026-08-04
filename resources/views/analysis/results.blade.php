@extends('layouts.app')

@section('title', 'Analysis Results - Lore.AI')

@section('content')
<div class="mb-4 flex-between">
    <div>
        <a href="{{ route('chapters.show', $chapter->id) }}" class="link-sm">&larr; Back to Chapter</a>
        <h2>DeepSeek AI Lore Analysis</h2>
        <div class="subtext">{{ $chapter->novel->title }} - Chapter {{ $chapter->chapter_number }}</div>
    </div>
</div>

<div class="card mb-4 bg-dark-card">
    <div class="card-header">
        <h3>Summary</h3>
    </div>
    <div class="card-body">
        <p class="summary-text">{{ $chapter->summary ?? 'No summary generated.' }}</p>
    </div>
</div>

<div class="grid-2col mb-4">
    <div class="card">
        <div class="card-header">
            <h3>Extracted Characters</h3>
        </div>
        <div class="card-body">
            @forelse($chapter->characters as $char)
                <div class="character-card">
                    <h4>{{ $char->name }} <span class="badge badge-realm">{{ $char->cultivation_realm }}</span></h4>
                    <p><strong>Role:</strong> {{ $char->role }}</p>
                    <p><strong>Faction:</strong> {{ $char->faction->name ?? 'Factions Unspecified' }}</p>
                    <p class="text-sm text-muted">{{ $char->description }}</p>
                </div>
            @empty
                <p class="text-muted">No characters extracted.</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Relationships & Dynamics</h3>
        </div>
        <div class="card-body">
            @forelse($chapter->relationships as $rel)
                <div class="rel-item">
                    <div class="rel-header">
                        <strong>{{ $rel->sourceCharacter->name }}</strong>
                        <span class="badge badge-rel">{{ $rel->relation_type }}</span>
                        <strong>{{ $rel->targetCharacter->name }}</strong>
                    </div>
                    @if($rel->notes)
                        <div class="text-sm text-muted mt-1">{{ $rel->notes }}</div>
                    @endif
                </div>
            @empty
                <p class="text-muted">No explicit character relationships detected in this chapter.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Extracted Lore Items & Artifacts</h3>
    </div>
    <div class="card-body">
        <div class="grid-3col">
            @forelse($loreItems as $item)
                <div class="lore-card">
                    <span class="badge badge-category">{{ $item['category'] ?? 'Lore' }}</span>
                    <h4>{{ $item['name'] ?? 'Unknown Item' }}</h4>
                    <p class="text-sm">{{ $item['description'] ?? 'No detail.' }}</p>
                </div>
            @empty
                <p class="text-muted">No special items or cultivation techniques found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

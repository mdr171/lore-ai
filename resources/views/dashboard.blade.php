@extends('layouts.app')

@section('title', 'Dashboard - Lore.AI')

@section('content')
<div class="dashboard-header">
    <h1>Dao of Knowledge Dashboard</h1>
    <p>Track characters, sects, and realm progression extracted directly from Xianxia novel chapters.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📚</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['total_novels'] }}</span>
            <span class="stat-label">Novels Tracked</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📜</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['total_chapters'] }}</span>
            <span class="stat-label">Chapters Analyzed</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">👤</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['total_characters'] }}</span>
            <span class="stat-label">Characters Extracted</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">⛩️</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['total_factions'] }}</span>
            <span class="stat-label">Factions / Sects</span>
        </div>
    </div>
</div>

<div class="grid-2col">
    <div class="card">
        <div class="card-header">
            <h3>Recent Chapters</h3>
            <a href="{{ route('chapters.index') }}" class="link-sm">View All</a>
        </div>
        <div class="card-body">
            @forelse($recentChapters as $chapter)
                <div class="list-item">
                    <div>
                        <strong>Chapter {{ $chapter->chapter_number }}: {{ $chapter->title }}</strong>
                        <div class="subtext">{{ $chapter->novel->title }}</div>
                    </div>
                    <div class="flex-align">
                        <span class="badge badge-{{ $chapter->status }}">{{ ucfirst($chapter->status) }}</span>
                        <a href="{{ route('chapters.show', $chapter->id) }}" class="btn btn-secondary-sm">Details</a>
                    </div>
                </div>
            @empty
                <p class="text-muted">No chapters submitted yet. Try adding one!</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Key Characters & Connections</h3>
        </div>
        <div class="card-body">
            @forelse($topCharacters as $char)
                <div class="list-item">
                    <div>
                        <strong>{{ $char->name }}</strong>
                        <div class="subtext">Realm: {{ $char->cultivation_realm }}</div>
                    </div>
                    <span class="badge badge-info">{{ $char->relationships_count }} Relations</span>
                </div>
            @empty
                <p class="text-muted">No character data available yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

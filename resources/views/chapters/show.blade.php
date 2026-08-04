@extends('layouts.app')

@section('title', 'Chapter Details - Lore.AI')

@section('content')
<div class="mb-4">
    <a href="{{ route('chapters.index') }}" class="link-sm">&larr; Back to Chapters</a>
</div>

<div class="card mb-4">
    <div class="card-header flex-between">
        <div>
            <h2>Chapter {{ $chapter->chapter_number }}: {{ $chapter->title }}</h2>
            <div class="subtext">Novel: {{ $chapter->novel->title }}</div>
        </div>
        <div>
            <span class="badge badge-{{ $chapter->status }}">{{ ucfirst($chapter->status) }}</span>
        </div>
    </div>
    <div class="card-body">
        <div class="action-bar mb-4">
            @if($chapter->status !== 'completed')
                <form action="{{ route('chapters.analyze', $chapter->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">⚡ Run DeepSeek Lore AI Analysis</button>
                </form>
            @else
                <a href="{{ route('analysis.results', $chapter->id) }}" class="btn btn-success">View Extracted Lore & Characters</a>
            @endif
        </div>

        <h3>Chapter Content Preview</h3>
        <div class="content-box">
            {{ Str::limit($chapter->content, 1000) }}
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Chapter List - Lore.AI')

@section('content')
<div class="flex-between mb-4">
    <h2>Chapter Archive</h2>
    <a href="{{ route('chapters.create') }}" class="btn btn-primary">+ Submit Chapter</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Novel</th>
                    <th>Chapter</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($chapters as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->novel->title }}</td>
                        <td>Ch. {{ $c->chapter_number }}</td>
                        <td><strong>{{ $c->title }}</strong></td>
                        <td><span class="badge badge-{{ $c->status }}">{{ ucfirst($c->status) }}</span></td>
                        <td>
                            <a href="{{ route('chapters.show', $c->id) }}" class="btn btn-secondary-sm">View</a>
                            @if($c->status === 'completed')
                                <a href="{{ route('analysis.results', $c->id) }}" class="btn btn-primary-sm">Lore Results</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No chapters found. Start by submitting a new chapter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $chapters->links() }}
        </div>
    </div>
</div>
@endsection

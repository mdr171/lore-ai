@extends('layouts.app')

@section('title', 'Submit Chapter - Lore.AI')

@section('content')
<div class="card max-w-2xl mx-auto">
    <div class="card-header">
        <h2>Paste Chapter for Lore Extraction</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('chapters.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="novel_name">Novel Title</label>
                <input type="text" name="novel_name" id="novel_name" class="form-control" placeholder="e.g. Renegade Immortal / Battle Through the Heavens" value="{{ old('novel_name') }}">
            </div>

            <div class="form-row">
                <div class="form-group col">
                    <label for="chapter_number">Chapter Number</label>
                    <input type="number" name="chapter_number" id="chapter_number" class="form-control" value="{{ old('chapter_number', 1) }}" required>
                </div>

                <div class="form-group col">
                    <label for="title">Chapter Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="e.g. Entering the Sun Moon Sect" value="{{ old('title') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="content">Chapter Raw Text</label>
                <textarea name="content" id="content" rows="12" class="form-control" placeholder="Paste full raw text of the chapter here..." required>{{ old('content') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit Chapter</button>
        </form>
    </div>
</div>
@endsection

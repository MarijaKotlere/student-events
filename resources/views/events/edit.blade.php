<x-layouts.app title="Edit Event">
    <h1>Edit Event</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('events.update', $event) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" class="form-control" value="{{ old('title', $event->title) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Event date</label>
            <input
                type="datetime-local"
                name="event_date"
                class="form-control"
                value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Location</label>
            <input name="location" class="form-control" value="{{ old('location', $event->location) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Max participants</label>
            <input type="number" name="max_participants" class="form-control" value="{{ old('max_participants', $event->max_participants) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
                <option value="">Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('events.show', $event) }}" class="btn btn-secondary">Back</a>
    </form>
</x-layouts.app>
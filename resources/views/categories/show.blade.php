<x-layouts.app title="Category Details">
    <h1>{{ $category->name }}</h1>

    <p>{{ $category->description }}</p>

    <h3>Events in this category</h3>

    @if ($category->events->count())
        <ul class="list-group">
            @foreach ($category->events as $event)
                <li class="list-group-item">
                    <a href="{{ route('events.show', $event) }}">
                        {{ $event->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-info">
            No events in this category.
        </div>
    @endif

    <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">
        Back
    </a>
</x-layouts.app>
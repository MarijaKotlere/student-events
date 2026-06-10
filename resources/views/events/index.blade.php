<x-layouts.app title="Events">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Student Events</h1>

        @auth
    <a href="{{ route('events.create') }}" class="btn btn-primary">
        Create Event
    </a>
        @endauth
    </div>

    <form method="GET" action="{{ route('events.index') }}" class="row g-3 mb-4">

        <div class="col-md-5">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search event..."
                value="{{ request('search') }}"
            >
        </div>

        <div class="col-md-4">
            <select name="category" class="form-select">

                <option value="">
                    All categories
                </option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ request('category') == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="col-md-3">
            <button class="btn btn-dark w-100">
                Filter
            </button>
        </div>

    </form>

    @if ($events->count())

        <div class="row">

            @foreach ($events as $event)

                <div class="col-md-6 col-lg-4 mb-4">

                    <div class="card h-100 shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">
                                {{ $event->title }}
                            </h5>

                            <p class="text-muted">
                                {{ $event->event_date->format('Y-m-d H:i') }}
                            </p>

                            <p>
                                <strong>Category:</strong>
                                {{ $event->category->name }}
                            </p>

                            <p>
                                <strong>Location:</strong>
                                {{ $event->location }}
                            </p>

                            <p>
                                <strong>Created by:</strong>
                                {{ $event->user->name }}
                            </p>

                            <p>
                                <strong>Participants limit:</strong>
                                {{ $event->max_participants ?? 'Unlimited' }}
                            </p>

                            <a
                                href="{{ route('events.show', $event) }}"
                                class="btn btn-primary btn-sm"
                            >
                                View details
                            </a>

                            @auth
    <a
        href="{{ route('events.edit', $event) }}"
        class="btn btn-warning btn-sm"
    >
        Edit
    </a>

    <form
        action="{{ route('events.destroy', $event) }}"
        method="POST"
        class="d-inline"
    >
        @csrf
        @method('DELETE')

        <button
            class="btn btn-danger btn-sm"
            onclick="return confirm('Delete event?')"
        >
            Delete
        </button>

    </form>
@endauth
                              
                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="alert alert-info">
            No events found.
        </div>

    @endif

</x-layouts.app>
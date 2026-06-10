<x-layouts.app title="Event Details">
    <h1>{{ $event->title }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>Date:</strong> {{ $event->event_date->format('Y-m-d H:i') }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Category:</strong> {{ $event->category->name }}</p>
            <p><strong>Created by:</strong> {{ $event->user->name }}</p>
            <p><strong>Max participants:</strong> {{ $event->max_participants ?? 'Unlimited' }}</p>
            <p><strong>Registrations:</strong> {{ $event->registrations->count() }}</p>

            @auth
                <form method="POST" action="{{ route('registrations.store', $event) }}" class="mb-3">
                    @csrf
                    <button class="btn btn-success">
                        Register for this event
                    </button>
                </form>

                @if($event->user_id === auth()->id() || auth()->user()->isAdmin())                                
                    <a href="{{ route('events.edit', $event) }}" class="btn btn-warning">
                        Edit
                    </a>
                @endif
            @endauth

            <a href="{{ route('events.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>
    </div>

    @guest
        <div class="alert alert-info">
            Please login or register to comment, rate or register for this event.
        </div>
    @endguest

    <hr>

    @auth
        <h3>Add Comment</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('comments.store', $event) }}" class="mb-4">
            @csrf

            <div class="mb-3">
                <textarea name="content" class="form-control" rows="3" placeholder="Write your comment...">{{ old('content') }}</textarea>
            </div>

            <button class="btn btn-primary">
                Add Comment
            </button>
        </form>
    @endauth

    <h3>Comments</h3>

    @if ($event->comments->count())
        @foreach ($event->comments as $comment)
            <div class="border p-2 mb-2">
                <strong>{{ $comment->user->name }}</strong>
                <p class="mb-0">{{ $comment->content }}</p>
                <form method='POST' action="{{ route('comments.destroy', $comment) }}">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger">
                        Delete Comment
                    </button>
                </form>
            </div>

        @endforeach
    @else
        <p>No comments yet.</p>
    @endif

    <hr>

    @auth
        <h3>Add Rating</h3>

        <form method="POST" action="{{ route('ratings.store', $event) }}" class="mb-4">
            @csrf

            <div class="mb-3">
                <select name="score" class="form-select">
                    <option value="">Select rating</option>
                    <option value="1">1 - Very bad</option>
                    <option value="2">2 - Bad</option>
                    <option value="3">3 - Normal</option>
                    <option value="4">4 - Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>

            <button class="btn btn-primary">
                Save Rating
            </button>
        </form>
    @endauth

    <h3>Ratings</h3>

    @if ($event->ratings->count())
        <p>
            Average rating:
            {{ round($event->ratings->avg('score'), 1) }} / 5
        </p>
    @else
        <p>No ratings yet.</p>
    @endif
</x-layouts.app>
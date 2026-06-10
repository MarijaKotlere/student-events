<x-layouts.app title="Create Category">
    <h1>Create Category</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the errors:</strong>

            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Category name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <button class="btn btn-primary">
            Save
        </button>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            Back
        </a>
    </form>
</x-layouts.app>
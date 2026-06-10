<x-layouts.app title="Edit Category">
    <h1>Edit Category</h1>

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

    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Category name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>

        <button class="btn btn-primary">
            Update
        </button>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            Back
        </a>
    </form>
</x-layouts.app>
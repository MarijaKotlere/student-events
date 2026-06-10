<x-layouts.app title="Categories">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Categories</h1>

        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            Add Category
        </a>
    </div>

    @if ($categories->count())
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Events count</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->events_count }}</td>
                    <td>
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-info">
                            View
                        </a>

                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete category?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            No categories found.
        </div>
    @endif
</x-layouts.app>
<x-layouts.app title="Users">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Users</h1>
    </div>

    @if ($users->count())
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->blocked)
                            <span class="badge bg-danger">Blocked</span>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    </td>
                    <td>
                        @if ($user->blocked)
                            <form action="{{ route('users.unblock', $user) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf

                                <button class="btn btn-sm btn-success"
                                        onclick="return confirm('Unblock this user?')">
                                    Unblock
                                </button>
                            </form>
                        @else
                            <form action="{{ route('users.block', $user) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf

                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Block this user?')">
                                    Block
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            No users found.
        </div>
    @endif
</x-layouts.app>
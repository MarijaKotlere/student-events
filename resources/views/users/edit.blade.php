<x-layouts.app title="Edit User">
    <h1>Edit User</h1>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input
                type="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="form-control"
                required
            >

            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                class="form-control"
                required
            >

            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">
                New Password (leave blank to keep current password)
            </label>

            <input
                type="password"
                name="password"
                class="form-control"
            >

            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Save Changes
        </button>
    </form>
</x-layouts.app>
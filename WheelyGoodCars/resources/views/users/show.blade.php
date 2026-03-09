<div>
    <h1>{{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>
    <p>Role: {{ $user->is_admin ? 'Admin' : 'User' }}</p>

    @if (Auth::id() == $user->id || Auth::user()->is_admin)
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit Profile</a>
    @endif
</div>
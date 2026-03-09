<form action="{{ route('users.index') }}" method="Get">
    <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}">
    <button type="submit">Search</button>
</form>
@guest
    <a href ="{{ route('users.create') }}">Create New User</a>
@endguest

<table class="">
    <thead>
        <tr>
            <th class="">ID</th>
            <th class="">Name</th>
            <th class="">Email</th>
            <th class="">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            <tr>
                <td class="">{{ $user->id }}</td>
                <td class="">{{ $user->name }}</td>
                <td class="">{{ $user->email }}</td>
                <td class="">
                    <a href="{{ route('users.show', $user->id) }}" class="">View</a>
                    @if(Auth::id() == $user->id || Auth::user()->is_admin)
                        <a href="{{ route('users.edit', $user->id) }}" class="">Edit</a>
                    
                        <form action="{{ route('users.disable', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="">Disable</button>
                        </form>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="">No users found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $users->links() }}
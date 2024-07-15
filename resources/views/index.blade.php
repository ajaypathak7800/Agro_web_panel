@extends('layout')

@section('content')
    <h2>Users</h2>
    <a href="{{ route('create') }}" class="btn btn-primary">Add New User</a>

    <!-- Flash message -->
    @if(session('success'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card-body">
        <div class="table-responsive" style="max-height: 550px; overflow: auto;">
            <table id="multi-filter-select" class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('edit', $user->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

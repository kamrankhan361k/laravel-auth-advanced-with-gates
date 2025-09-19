@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin Dashboard</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h3>Users Management</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge bg-primary">{{ $role->display_name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('assign-role')
                                <form action="{{ route('admin.assign-role', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    <select name="role" class="form-select form-select-sm d-inline" style="width: auto;">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->display_name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Assign Role</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('header_title', 'User Management')
@section('content')
    <div class="admin-container">
        <table class="user-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <select class="role-select" data-user="{{ $user->id }}">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @vite('resources/js/admin.ts')
@endsection

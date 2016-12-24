@extends('layouts.admin')
@section('content')
    <table class="table table-hover table-bordered">
        <tr class="text-center">
            <th>ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created</th>
            <th class="text-center">Operations</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->username}}</td>
                <td>{{$user->email}}</td>
                <td class="text-center">{{implode(",",$user->roles->pluck('name')->toArray())}}</td>
                <td>{{$user->createdAtHuman}}</td>
                <td class="text-center">
                    <span class="fa fa-edit text-primary"></span>&nbsp;
                    <a href="{{route('delete-user', $user->id)}}" onclick="return confirm('Are you sure to delete');">
                        <span class="fa fa-trash text-danger"></span>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
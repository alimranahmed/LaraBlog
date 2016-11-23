@extends('layouts.admin')
@section('content')
    <table class="table table-hover table-bordered">
        <tr class="text-center">
            <th>ID</th>
            <th>Name</th>
            <th>Created</th>
            <th>Operations</th>
        </tr>
        @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->createdAtHuman}}</td>
                <td>Edit | Delete</td>
            </tr>
        @endforeach
    </table>
@endsection
@extends('layouts.admin')
@section('content')
    <table class="table table-hover table-bordered">
        <tr class="text-center">
            <th>ID</th>
            <th>Name</th>
            <th>Created</th>
            <th>Articles</th>
            <th class="text-center">Operations</th>
        </tr>
        @foreach($keywords as $keyword)
            <tr>
                <td>{{$keyword->id}}</td>
                <td>{{$keyword->name}}</td>
                <td>{{$keyword->createdAtHuman}}</td>
                <td>{{$keyword->articles->count()}}</td>
                <td class="text-center">
                    <span class="fa fa-edit text-primary"></span>&nbsp;
                    <span class="fa fa-trash text-danger"></span>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
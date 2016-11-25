@extends('layouts.admin')
@section('content')
    <table class="table table-hover table-bordered">
        <tr class="text-center">
            <th>ID</th>
            <th>Name</th>
            <th>Alias</th>
            <th>Created</th>
            <th>Articles</th>
            <th class="text-center">Operations</th>
        </tr>
        @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->alias}}</td>
                <td>{{$category->createdAtHuman}}</td>
                <td>
                    <a href="{{route('articles-by-category', $category->alias)}}">{{$category->articles->count()}}</a>
                </td>
                <td class="text-center">
                    <span class="fa fa-edit text-primary"></span>&nbsp;
                    <span class="fa fa-trash text-danger"></span>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
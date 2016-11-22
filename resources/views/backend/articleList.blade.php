@extends('layouts.admin')
@section('content')
    <table class="table table-hover table-bordered">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Written</th>
            <th>Published</th>
            <th>Written</th>
            <th>Last Edited</th>
            <th>Comments</th>
            <th>Hits</th>
        </tr>
        @foreach($articles as $article)
            <tr>
                <td>{{$article->id}}</td>
                <td>{{$article->heading}}</td>
                <td>{{$article->category->name}}</td>
                <td>{{$article->created_at}}</td>
                <td>{{$article->published_at}}</td>
                <td>{{$article->user->name}}</td>
                <td>{{$article->updated_at}}</td>
                <td>{{$article->comment_count}}</td>
                <td>{{$article->hit_count}}</td>
            </tr>
        @endforeach
    </table>
@endsection
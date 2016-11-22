@extends('layouts.admin')
@section('content')
    <table class="table table-hover table-bordered">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Written</th>
            <th>Published</th>
            <th>Last</th>
            <th>Comments</th>
            <th>Hits</th>
            <th>Operations</th>
        </tr>
        @foreach($articles as $article)
            <tr>
                <td>{{$article->id}}</td>
                <td>{{$article->heading}}</td>
                <td>{{$article->category->name}}</td>
                <td>{{$article->createdAtHuman}}</td>
                <td>{{$article->publishedAtHuman}}</td>
                <td>{{$article->updatedAtHuman}}</td>
                <td>{{$article->comment_count}}</td>
                <td>{{$article->hit_count}}</td>
                <td>Show | Edit | Delete</td>
            </tr>
        @endforeach
    </table>
@endsection
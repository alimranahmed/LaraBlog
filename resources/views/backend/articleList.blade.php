@extends('layouts.admin')
@section('content')
    <table class="table table-hover table-bordered">
        <tr class="text-center">
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Written</th>
            <th>Is Published</th>
            <th>Published</th>
            <th>Edited</th>
            <th>Comments</th>
            <th>Hits</th>
            <th>Operations</th>
        </tr>
        @foreach($articles as $article)
            <tr>
                <td>{{$article->id}}</td>
                <td>{{$article->heading}}</td>
                <td>{{$article->category->name}}</td>
                <td class="text-center">{{$article->createdAtHuman}}</td>
                <td class="text-center">
                    <a href="{{route('toggle-article-publish', $article->id)}}">
                        <strong class="fa fa-lg {{$article->is_published ? 'fa-toggle-on text-success' : 'fa-toggle-off text-grey'}}"></strong>
                    </a>
                </td>
                <td class="text-center">
                    <span class="{{!$article->is_published?'hide':''}}">{{$article->publishedAtHuman}}</span>
                </td>
                <td class="text-center">{{$article->updatedAtHuman}}</td>
                <td class="text-center">{{$article->comment_count}}</td>
                <td class="text-center">{{$article->hit_count}}</td>
                <td class="text-center">
                    <span class="fa fa-edit text-primary"></span>&nbsp;
                    <span class="fa fa-trash text-danger"></span>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
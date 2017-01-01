@extends('layouts.admin')
@section('content')
    <div class="row">
        <a href="{{route('create-article')}}" class="margin-top-5 margin-bottom-5 btn btn-success">Post New Article</a>
    </div>
    <div class="row">
        <table class="table table-hover table-bordered">
            <tr class="text-center">
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Written</th>
                <th>Language</th>
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
                    <td>
                        <a href="{{route('get-article', $article->id)}}" target="_blank">{{$article->heading}}</a>
                    </td>
                    <td>{{$article->category->name}}</td>
                    <td class="text-center">{{$article->createdAtHuman}}</td>
                    <td class="text-center">{{$article->language}}</td>
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
                        <a href="{{route('edit-article', $article->id)}}">
                            <span class="fa fa-edit text-primary"></span>
                        </a>&nbsp;
                        <a href="{{route('delete-article', $article->id)}}"
                           onclick="return confirm('Are you sure to delete?')">
                            <span class="fa fa-trash text-danger"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
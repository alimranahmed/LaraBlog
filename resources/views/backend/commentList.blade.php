@extends('layouts.admin')
@section('content')
    <table class="table table-hover table-bordered">
        <tr class="text-center">
            <th>ID</th>
            <th>Comment</th>
            <th>By</th>
            <th>Commented</th>
            <th>Published</th>
            <th>Article</th>
            <th>Operations</th>
        </tr>
        @foreach($comments as $comment)
            <tr>
                <td>{{$comment->id}}</td>
                <td>{{$comment->content}}</td>
                <td>{{$comment->user->name.' ('.$comment->user->email.')'}}</td>
                <td class="text-center">{{$comment->createdAtHuman}}</td>
                <td class="text-center">
                    <a href="{{route('toggle-comment-publish', $comment->id)}}">
                        <strong class="fa fa-lg {{$comment->is_published ? 'fa-toggle-on text-success' : 'fa-toggle-off text-grey'}}"></strong>
                    </a>
                </td>
                <td>
                    <a href="{{route('get-article', $comment->article->id)}}">{{substr($comment->article->heading, 0, 20)}}...</a>
                </td>
                <td class="text-center">
                    <span class="fa fa-edit text-primary"></span>&nbsp;
                    <a href="{{route('delete-comment', $comment->id)}}" onclick="return confirm('Are you sure to delete?')">
                        <span class="fa fa-trash text-danger"></span>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
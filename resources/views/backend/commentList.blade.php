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
                <td>{{$comment->user->email}}</td>
                <td class="text-center">{{$comment->createdAtHuman}}</td>
                <td class="text-center">
                    <strong class="fa fa-lg {{$comment->is_published ? 'fa-toggle-on text-success' : 'fa-toggle-off text-grey'}}"></strong>
                </td>
                <td>{{substr($comment->article->heading, 0, 20)}}...</td>
                <td class="text-center">
                    <span class="fa fa-edit text-primary"></span>&nbsp;
                    <span class="fa fa-trash text-danger"></span>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
@extends('layouts.admin')
@section('content')
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>All Feedbacks</strong>
        </div>
        <div class="panel-body">
            <form action="{{route('add-keyword')}}" method="post">
                {{csrf_field()}}
                <table class="table table-hover" id="keywordList">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Content</th>
                        <th>Created</th>
                        <th>Resolved?</th>
                        <th class="text-center">Operations</th>
                    </tr>
                    @foreach($feedbacks as $feedback)
                        <tr>
                            <td>{{$feedback->id}}</td>
                            <td>{{$feedback->name}}</td>
                            <td>{{$feedback->email}}</td>
                            <td>{{$feedback->content}}</td>
                            <td>{{$feedback->createdAtHuman}}</td>
                            <td class="text-center">{{$feedback->is_resolved ? 'Yes' : 'No'}}</td>
                            <td class="text-center">
                                <a href="{{route('toggle-feedback-resolved', $feedback->id)}}">
                                    <span class="fa fa-lg {{$feedback->is_resolved ? 'fa-toggle-on text-success' : 'fa-toggle-off text-grey'}}"></span>
                                </a>
                                <a href="{{route('close-feedback', $feedback->id)}}" onclick="return confirm('Are you sure to close?');">
                                    <span class="fa fa-trash text-danger"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{$feedbacks->links()}}
            </form>
        </div>
    </div>
@endsection

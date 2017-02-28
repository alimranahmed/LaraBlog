@extends('layouts.admin')
@section('content')
    <form action="{{route('add-keyword')}}" method="post">
        {{csrf_field()}}
        <table class="table table-hover table-bordered" id="keywordList">
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
    </form>
    <!-- Modal -->
    <div class="modal fade" id="keyword-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Keyword</h4>
                </div>
                <form class="form-inline" id="keyword-form" method="POST">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group {{$errors->has('name') ? 'has-error has-feedback' : ''}}">
                            <label>Name</label>
                            <input name="name" placeholder="Name" id="name" class="form-control" value="{{old('name')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
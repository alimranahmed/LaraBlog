@extends('layouts.admin')
@section('content')
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>All Comments</strong>
        </div>
        <div class="panel-body">
            <table class="table table-hover" id="commentList">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Comment</th>
                    <th>By</th>
                    <th>Commented</th>
                    <th>Article</th>
                    <th>Operations</th>
                </tr>
                @foreach($comments as $comment)
                    <tr>
                        <td>{{$comment->id}}</td>
                        <td>{{$comment->content}}</td>
                        <td>
                            <span>{{$comment->user->name}}</span>
                            <span>{{' ('.$comment->user->email.')'}}</span>
                            <span>{{isset($comment->address->country_name) ? '('.$comment->address->city.', '.$comment->address->country_name.')' : ''}}</span>
                        </td>
                        <td class="text-center">{{$comment->createdAtHuman}}</td>
                        <td>
                            <a href="{{route('get-article', $comment->article->id)}}" target="_blank">{{substr($comment->article->heading, 0, 20)}}...</a>
                        </td>
                        <td class="text-center">
                            <a href="{{route('toggle-comment-publish', $comment->id)}}">
                                <strong class="fa fa-lg {{$comment->is_published ? 'fa-toggle-on text-success' : 'fa-toggle-off text-grey'}}"></strong>
                            </a>
                            <span class="fa fa-edit text-primary pointer" v-on:click="showCommentForm({{$comment}})"></span>&nbsp;
                            <a href="{{route('delete-comment', $comment->id)}}" onclick="return confirm('Are you sure to delete?')">
                                <span class="fa fa-trash text-danger"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
            <!-- Modal -->
            <div class="modal fade" id="comment-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Edit Comment</h4>
                        </div>
                        <form id="comment-form" method="POST">
                            <div class="modal-body">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea name="content" placeholder="Content" id="content" class="form-control"></textarea>
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
        </div>
    </div>
@endsection

@section('inPageJS')
    @parent
    <script>
        new Vue({
            el: "#commentList",
            data: {},
            methods: {
                showCommentForm: function(comment){
                    $("#content").val(comment.content);
                    $("#comment-form").attr("action", "comment/" + comment.id);
                    $("#comment-modal").modal("show");
                }
            }
        });
    </script>
@endsection
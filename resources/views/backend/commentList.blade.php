@extends('layouts.admin')
@section('content')
    <table class="table table-hover table-bordered" id="commentList">
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
                    <span class="fa fa-edit text-primary pointer" v-on:click="showCommentForm({{$comment}})"></span>&nbsp;
                    <a href="{{route('delete-comment', $comment->id)}}" onclick="return confirm('Are you sure to delete?')">
                        <span class="fa fa-trash text-danger"></span>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
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

@section('inPageJS')
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
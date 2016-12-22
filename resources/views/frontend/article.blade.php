@extends('layouts.public')
@section('content')
    <div id="article">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="article-heading text-xlg">{{$article->heading}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-justify text-md">{!! $article->content !!}</div>
        </div>
        <div class="row margin-top-15" style="display: none;" id="comment-form">
            @include('frontend._form_comment')
        </div>
        <div class="row">
            <div class="col-sm-12">
                <strong class="text-lg">Comments({{count($article->comments)}})</strong>
                <span class="fa fa-3x fa-commenting-o text-primary pointer" id="comment-btn"
                      title="Post a comment"></span>
            </div>
        </div>
        <hr class="margin-bottom-15 margin-top-10">
        <section id="comments">
            @include('frontend._comments', ['comments' => $article->comments])
        </section>
    </div>
@endsection

@section("inPageJS")
    <script>
        new Vue({
            el: "#comment-form",
            data: { comment:{}},
            methods:{
                addComment : function(comment){
                    console.debug(comment);
                    Vue.http.post("{{route('add-comment', $article->id)}}", comment)
                            .then(function(response){
                                $("#comments").html(response.body);
                                $('#comment-form').hide();
                                var successAlert = $('#success-alert');
                                successAlert.show();
                                successAlert.fadeOut(1000 * 10);
                                $('#success-msg').html('Comment posted successfully');
                            }, function(response){
                                var errorAlert = $('#error-alert');
                                errorAlert.show();
                                errorAlert.fadeOut(1000 * 10);
                                $('#error-msg').html('Operation failed, please try again');
                            });
                    return false;
                }
            }
        });
    </script>
@endsection
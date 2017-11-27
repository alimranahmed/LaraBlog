@extends('layouts.public')
@section('content')
    <div id="article">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="article-heading text-xlg no-margin-bottom">{{$article->heading}}</h1>
                <div class="margin-bottom-10">
                    <span class="text-grey">Written {{$article->createdAtHuman}}</span>
                    <span class="text-grey">by {{$article->user->name}} on </span>
                    <a href="{{route('articles-by-category', $article->category->alias)}}">{{$article->category->name}}</a>
                    @if(Auth::check() && (\Entrust::hasRole(['owner', 'admin']) || $article->user->id == Auth::user()->id))
                        <a href="{{route('edit-article', $article->id)}}"><span class="fa fa-edit"></span></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-justify text-md">{!! $article->content !!}</div>
        </div>
        <hr class="margin-bottom-10 margin-top-10">
        <div class="row">
            <div class="col-sm-1"><strong>Keywords:</strong></div>
            <div class="col-md-11">
                @foreach($article->keywords as $keyword)
                    <a href="{{route('articles-by-keyword', [$keyword->name])}}">
                        <span class="label label-info">{{$keyword->name}}</span>
                    </a>
                @endforeach
            </div>
        </div>
        <hr class="margin-bottom-10 margin-top-10">
        @if(!$relatedArticles->isEmpty())
            <div class="row">
                <div class="col-sm-12 text-lg">
                    <strong>More Articles on
                        <a href="{{route('articles-by-category', ['categoryAlias' => $article->category->alias])}}">{{$article->category->name}}</a>
                    </strong>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12" id="related-articles">
                    @include('frontend._article_list', ['articles' => $relatedArticles])
                </div>
            </div>
        @endif
        @if($article->is_comment_enabled)
            <div class="row margin-top-15" id="comment-form">
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
            <section id="comments" class="margin-bottom-15">
                @include('frontend._comments', ['article' => $article, 'comments' => $article->comments->where('parent_comment_id', null)])
            </section>
        @endif
    </div>
@endsection

@section("inPageJS")
    @parent
    <script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5a1b6e761d108f0012ed9df0&product=sticky-share-buttons"></script>
    <script>
        new Vue({
            el: "#article",
            data: {comment: {}, reply: {}},
            methods: {
                addComment: function (comment) {
                    console.log(comment);
                    Vue.http.post("{{route('add-comment', $article->id)}}", comment)
                        .then(function (response) {
                            //hide comment form
                            $("#comments").html(response.body);
                            $('#comment-form').hide();
                            //show success alert
                            var successAlert = $('#success-alert');
                            successAlert.show();
                            successAlert.fadeOut(1000 * 10);
                            $('#success-msg').html('Success! your comment will be published soon');
                            //clear form values
                            $('input').val('');
                            $('textarea').val('')
                        }, function (response) {
                            //show error alert
                            var errorAlert = $('#error-alert');
                            errorAlert.show();
                            errorAlert.fadeOut(1000 * 10);
                            console.debug(response);
                            $('#error-msg').html(response.body.errorMsg);
                        });
                    return false;
                },

                initiateReplyForm: function(commentID){
                    $("#parent_comment_id").val(commentID);
                },

                addReply: function (reply) {
                    reply.parent_comment_id = $("#parent_comment_id").val();
                    console.log(reply);
                    Vue.http.post("{{route('add-comment', $article->id)}}", reply)
                        .then(function (response) {
                            //hide comment form
                            $("#comments").html(response.body);
                            $('.modal').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            //show success alert
                            var successAlert = $('#success-alert');
                            successAlert.show();
                            successAlert.fadeOut(1000 * 10);
                            $('#success-msg').html('Success! your reply will be published soon');
                            //clear form values
                            $('input').val('');
                            $('textarea').val('')
                        }, function (response) {
                            //show error alert
                            var errorAlert = $('#error-alert');
                            errorAlert.show();
                            errorAlert.fadeOut(1000 * 10);
                            console.debug(response);
                            $('#error-msg').html(response.body.errorMsg);
                        });
                    return false;
                }
            }
        });
    </script>
@endsection
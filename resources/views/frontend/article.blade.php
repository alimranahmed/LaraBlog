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
        @if(!$relatedArticles->isEmpty())
            <div class="row">
                <div class="col-sm-12 text-lg">
                    <strong>More Articles on
                        <a href="{{route('articles-by-category', ['categoryAlias' => $article->category->alias])}}">{{$article->category->name}}</a>
                    </strong>
                </div>
            </div><hr>
            <div class="row">
                <div class="col-sm-12" id="related-articles">
                    @include('frontend._article_list', ['articles' => $relatedArticles])
                </div>
            </div>
        @endif
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
    @parent
    <script>
        new Vue({
            el: "#comment-form",
            data: { comment:{}},
            methods:{
                addComment : function(comment){
                    console.debug(comment);
                    Vue.http.post("{{route('add-comment', $article->id)}}", comment)
                            .then(function(response){
                                //hide comment form
                                $("#comments").html(response.body);
                                $('#comment-form').hide();
                                //show success alert
                                var successAlert = $('#success-alert');
                                successAlert.show();
                                successAlert.fadeOut(1000 * 10);
                                $('#success-msg').html('An email has been set to the email to confirm your comment');
                                //clear form values
                                $('input').val('');
                                $('textarea').val('')
                            }, function(response){
                                //show error alert
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
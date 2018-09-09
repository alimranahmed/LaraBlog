@extends('layouts.public')
@section('content')
    <div id="article">

        <single-article
                :article="{{ $article }}"
                {{ $article->canEdit ? ':can_edit=true' : ':can_edit=false' }}
                :article_edit_url="'{{ route('edit-article', $article->id) }}'"
                :article_by_category_url="'{{ route('articles-by-category', $article->category->alias) }}'">
        </single-article>

        <keywords :keywords="{{$article->keywords}}"></keywords>

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
                <comment-form :add_comment_url="'{{route('add-comment', $article->id)}}'"></comment-form>
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

@section("pageJS")
    @parent
    @include('frontend._share_script')
@show
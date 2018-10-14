@extends('layouts.admin')

@section('content')
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>Edit Articles</strong>
        </div>
        <div class="panel-body" id="edit-article">
            <article-form
                    :url="'{{ route('update-article', $article->id) }}'"
                    :languages="{{ assoc2JsonArray(config('fields.lang'))}}"
                    :method="'PUT'"
                    :article="{{ json_encode($article) }}"
                    :categories="{{ json_encode($categories) }}">
            </article-form>
        </div>
    </div>
@endsection
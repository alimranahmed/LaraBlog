@extends('layouts.admin')

@section('content')
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>Write New Article</strong>
        </div>
        <div class="panel-body" id="create-article">
            <article-form
                    :url="'{{route('store-article')}}'"
                    :languages="{{ assoc2JsonArray(config('fields.lang'))}}"
                    :method="'POST'"
                    :categories="{{ json_encode($categories) }}">
            </article-form>
        </div>
    </div>
    </div>
@endsection
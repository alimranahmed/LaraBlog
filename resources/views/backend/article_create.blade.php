@extends('layouts.admin')

@section('content')
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>Write New Article</strong>
        </div>
        <div class="panel-body" id="create-article">
            <div role="tabpanel" class="tab-pane active" id="editor">
                <article-form
                        :url="'{{route('store-article')}}'"
                        :languages="{{ assoc2JsonArray(config('fields.lang'))}}"
                        :categories="{{ json_encode($categories) }}"></article-form>
            </div>
            <div role="tabpanel" class="tab-pane" id="preview">
                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="article-heading text-xlg" id="article-heading"></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-justify text-md" id="article-content"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
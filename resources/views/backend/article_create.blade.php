@extends('layouts.admin')

@section('content')
    <div id="create-article">
        <h2>Write New Article</h2>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs margin-bottom-5" role="tablist">
            <li role="presentation" class="active">
                <a href="#editor" aria-controls="home" role="tab" data-toggle="tab">Editor</a>
            </li>
            <li role="presentation" v-on:click="updatePreview(article)">
                <a href="#preview" aria-controls="settings" role="tab" data-toggle="tab">Preview</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="editor">
                <form action="{{route('store-article')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="text" v-model="article.heading" class="form-control" name="heading" placeholder="*Heading..." required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="content" v-model="article.content" class="form-control" rows="10" placeholder="*Write here..." required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Create</button>
                    </div>
                </form>
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

@section('inPageJS')
    <script>
        new Vue({
            el: "#create-article",
            data: {
                'article':{'heading': '', 'content':''}
            },
            methods:{
                'updatePreview': function(article){
                    $("#article-heading").html(article.heading);
                    $("#article-content").html(article.content);
                }
            }
        });
    </script>
@endsection
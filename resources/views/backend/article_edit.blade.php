@extends('layouts.admin')

@section('content')
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>Edit Articles</strong>
        </div>
        <div class="panel-body" id="edit-article">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs margin-bottom-5" role="tablist">
                <li role="presentation" class="active">
                    <a href="#editor" aria-controls="home" role="tab" data-toggle="tab">Editor</a>
                </li>
                <li role="presentation" v-on:click="updatePreview()">
                    <a href="#preview" aria-controls="settings" role="tab" data-toggle="tab">Preview</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="editor">
                    <form action="{{route('update-article', $article->id)}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <input type="text" id="heading" class="form-control" name="heading"
                                   placeholder="*Heading..." required value="{{$article->heading}}">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="category_id">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$article->category_id == $category->id ? 'selected':''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-grey">
                            Tips for article content: Enclose source inside &lt;pre&gt;&lt;code&gt;...&lt;/code&gt;&lt;/pre&gt;
                        </div>
                        <div class="form-group">
                            <textarea name="content" id="content" class="form-control textarea-indent" rows="10"
                                      placeholder="*Write here..." required>{!! $article->content !!}</textarea>
                        </div>
                        <div class="text-grey">
                            Tips for keywords: separate your keywords by space. Some popular keywords are:
                        </div>
                        <div class="form-group">
                            <strong>Keywords: </strong><label id="keywords-show"></label>
                            <input type="text" id="keyword" v-on:keyup="formatKeyword('#keyword', '#keywords-show')"
                                   class="form-control" name="keywords" placeholder="Keywords"
                                   value="{{implode(' ',$article->keywords->pluck('name')->toArray())}}">
                        </div>
                        <div class="form-group">
                            <input type="radio" name="language"
                                   value="বাংলা" {{$article->language == 'বাংলা' ? 'checked' : ''}}>
                            <label>বাংলা</label>
                            <input type="radio" name="language"
                                   value="English" {{$article->language == 'English' ? 'checked' : ''}}>
                            <label>English</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Update</button>
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
    </div>
@endsection

@section('inPageJS')
    @parent
    <script>
        new Vue({
            el: "#edit-article",
            data: {
                'article': {'heading': '', 'content': ''}
            },
            methods: {
                'updatePreview': function () {
                    $("#article-heading").html($("#heading").val());
                    $("#article-content").html($("#content").val());
                },

                'formatKeyword': function (inputId, displayId) {

                    var keywords = $(inputId).val().split(' ');
                    var htmlToShow = '';
                    for (var i = 0; i < keywords.length; i++) {
                        htmlToShow += "<span class='label label-info margin-right-5'>" + keywords[i] + "</span>";
                    }
                    $(displayId).html(htmlToShow);
                }
            },
            created: function () {
                this.formatKeyword("#keyword", "#keywords-show");
            }
        });
    </script>
@endsection
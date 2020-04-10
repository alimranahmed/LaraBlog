@extends('layouts.admin')
@section('content')
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>All Articles</strong>&nbsp;
            <a href="{{route('create-article')}}"><span class="fa fa-plus"></span></a>
            <form method="get" class="form-inline d-inline text-right">
                <select name="category" class="form-control margin-left-30">
                    <option value="">All categories</option>
                    @foreach($navCategories as $category)
                        <option value="{{$category->id}}" {{request('category') == $category->id ? 'selected' : ''}}>
                            {{$category->name}}
                        </option>
                    @endforeach
                </select>
                <button class="fa fa-search btn btn-success"></button>
            </form>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Written</th>
                    <th>Language</th>
                    <th>Published</th>
                    <th>Edited</th>
                    <th>Comments</th>
                    <th>Operations</th>
                </tr>
                @foreach($articles as $article)
                    <tr>
                        <td>{{$article->id}}</td>
                        <td>
                            <a href="{{route('get-article', [$article->id, make_slug($article->heading)])}}"
                               target="_blank">{{$article->heading}}</a>
                        </td>
                        <td>{{$article->categoryName}}</td>
                        <td class="text-center">{{$article->createdAtHuman}}</td>
                        <td class="text-center">{{$article->language}}</td>
                        <td class="text-center">
                            <span class="{{!$article->is_published?'hide':''}}">{{$article->publishedAtHuman}}</span>
                        </td>
                        <td class="text-center">{{$article->updatedAtHuman}}</td>
                        <td class="text-center">{{$article->is_comment_eanabled ? $article->comment_count : 'N/A'}}</td>
                        <td class="text-center">
                            <a href="{{route('edit-article', $article->id)}}">
                                <span class="fa fa-edit text-primary"></span>
                            </a>&nbsp;
                            <a href="{{route('toggle-article-publish', $article->id)}}">
                                <strong
                                    class="fa fa-lg {{$article->is_published ? 'fa-toggle-on text-success' : 'fa-toggle-off text-grey'}}"
                                    title="Toggle publish"></strong>
                            </a>&nbsp;
                            <a href="{{route('delete-article', $article->id)}}"
                               onclick="return confirm('Are you sure to delete?')">
                                <span class="fa fa-trash text-danger"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{$articles->links()}}
        </div>
    </div>
@endsection

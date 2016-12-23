@extends('layouts.admin')

@section('content')
    <h2>Edit Article</h2>
    <form action="{{route('update-article', $article->id)}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <input type="text" class="form-control" name="heading" placeholder="*Heading..." required value="{{$article->heading}}">
        </div>
        <div class="form-group">
            <select class="form-control" name="category_id">
                @foreach($categories as $category)
                    <option value="{{$category->id}}" {{$article->category_id == $category->id ? 'selected':''}}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <textarea name="content" class="form-control" rows="10" placeholder="*Write here..." required>{!! $article->content !!}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
@endsection
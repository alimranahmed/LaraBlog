@extends('layouts.admin')

@section('content')
    <h2>Write Article</h2>
    <form action="{{route('store-article')}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <input type="text" class="form-control" name="heading" placeholder="*Heading..." required>
        </div>
        <div class="form-group">
            <select class="form-control" name="category_id">
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <textarea name="content" class="form-control" rows="10" placeholder="*Write here..." required></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Create</button>
        </div>
    </form>
@endsection
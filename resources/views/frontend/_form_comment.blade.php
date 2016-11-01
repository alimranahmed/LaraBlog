<div class="col-sm-12">
    <form action="{{route('add-comment', $article->id)}}" method="post" name="add_comment_form">
        {{csrf_field()}}
        <div class="form-group {{$errors->has('content') ? 'has-error has-feedback' : ''}}">
                    <textarea name="content" class="form-control" id="comment"
                              placeholder="Comment*">{{old('content')}}</textarea>
        </div>
        <div class="form-group">
            <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name"
                   placeholder="Name">
        </div>
        <div class="form-group {{$errors->has('email') ? 'has-error has-feedback' : ''}}">
            <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email"
                   placeholder="Email">
        </div>
        <button type="submit" class="btn btn-primary pull-right">Comment</button>
    </form>
</div>
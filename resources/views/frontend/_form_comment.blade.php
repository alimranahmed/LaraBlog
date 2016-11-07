<div class="col-sm-12">
    <form action="{{route('add-comment', $article->id)}}" method="post" name="add_comment_form">
        {{csrf_field()}}
        <div class="form-group col-sm-12 no-padding {{$errors->has('content') ? 'has-error has-feedback' : ''}}">
            <textarea name="content" class="form-control" id="comment" rows="3"
                      placeholder="Comment*">{{old('content')}}</textarea>
        </div>
        <div class="form-group col-sm-4 no-padding-left">
            <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Name">
        </div>
        <div class="form-group col-sm-4 no-padding-right {{$errors->has('email') ? 'has-error has-feedback' : ''}}">
            <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email"
                   placeholder="Email">
        </div>
        <div class="form-group col-sm-4 no-padding-right {{$errors->has('password') ? 'has-error has-feedback' : ''}}">
            <input type="password" name="password" value="{{old('password')}}" class="form-control" id="paassword"
                   placeholder="Password">
        </div>
        <div class="form-group col-sm-8 col-sm-offset-4 no-padding-right checkbox">
            <label>
                <input type="checkbox" name="notify"> Notify me about new article
            </label>
            <button type="submit" class="btn btn-primary pull-right">Comment</button>
        </div>
    </form>
</div>
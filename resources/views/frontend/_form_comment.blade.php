<div class="col-sm-12" id="comment-form">
    <form action="{{route('add-comment', $article->id)}}" method="post" onsubmit="return false;" name="add_comment_form" v-on:submit="addComment({{$article->id}})">
        {{csrf_field()}}
        <div class="form-group col-sm-12 no-padding {{$errors->has('content') ? 'has-error has-feedback' : ''}}">
            <textarea name="content" class="form-control" id="comment" rows="3"
                      placeholder="Comment*" required>{{old('content')}}</textarea>
        </div>
        <div class="form-group col-sm-6 no-padding-left {{$errors->has('name') ? 'has-error has-feedback' : ''}}">
            <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Name*" required>
        </div>
        <div class="form-group col-sm-6 no-padding-right {{$errors->has('email') ? 'has-error has-feedback' : ''}}">
            <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email"
                   placeholder="Email*" required>
        </div>
        <div class="form-group col-sm-6 col-sm-offset-6 no-padding-right checkbox">
            <label>
                <input type="checkbox" name="notify"> Notify me about new article
            </label>
            <button type="submit" class="btn btn-primary pull-right">Comment</button>
        </div>
    </form>
</div>

@section("inPageJS")
    <script>
        new Vue({
            el: "#comment-form",
            data: {},
            methods:{
                addComment : function(){
                    console.debug("add comment");
                    return false;
                }
            }
        });
    </script>
@endsection
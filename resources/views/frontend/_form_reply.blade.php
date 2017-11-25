<!-- Modal -->
<div class="modal fade" id="reply-form" tabindex="-1" role="dialog" aria-labelledby="reply-form">
    <div class="modal-dialog" role="document">
        <form action="#" method="post" onsubmit="return false;"
              name="add_comment_form"
              v-on:submit="addReply(reply)">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Reply</h4>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12">
                        {{csrf_field()}}
                        <input type="hidden" v-model="reply.parent_comment_id" name="parent_comment_id" id="parent_comment_id">
                        <div class="form-group col-sm-12 no-padding {{$errors->has('content') ? 'has-error has-feedback' : ''}}">
                        <textarea name="content" class="form-control" id="comment" rows="3" v-model="reply.content"
                                  placeholder="Comment*" required>{{old('content')}}</textarea>
                        </div>
                        <div class="form-group col-sm-6 no-padding-left {{$errors->has('name') ? 'has-error has-feedback' : ''}}">
                            <input type="text" name="name" value="{{old('name')}}" class="form-control"
                                   v-model="reply.name"
                                   id="name" placeholder="Name*" required>
                        </div>
                        <div class="form-group col-sm-6 no-padding-right {{$errors->has('email') ? 'has-error has-feedback' : ''}}">
                            <input type="email" name="email" value="{{old('email')}}" class="form-control"
                                   v-model="reply.email"
                                   id="email" placeholder="Email*" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group col-sm-12 no-padding-right checkbox">
                        <label class="padding-right-5">
                            <input type="checkbox" name="notify"> Notify me about new article
                        </label>
                        <button type="submit" class="btn btn-primary pull-right">Reply</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
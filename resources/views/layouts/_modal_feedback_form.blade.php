<div class="modal fade" id="feedback-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Feel free to share your thoughts</h4>
            </div>
            <form method="post" action="{{route('add-feedback')}}">
                {{csrf_field()}}
                <div class="modal-body">
                    <input type="text" placeholder="Name*" name="name" class="form-control" required>
                    <input type="email" placeholder="Email*" name="email" class="form-control margin-top-10" required>
                    <textarea placeholder="Feedback*" class="form-control margin-top-10" name="content" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
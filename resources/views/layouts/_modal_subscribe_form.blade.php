<div class="modal fade" id="subscribe-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Subscribe to be notified about new article</h4>
            </div>
            <form method="post" action="{{route('subscribe')}}">
                {{csrf_field()}}
                <div class="modal-body">
                    <input type="text" placeholder="Name*" name="name" class="form-control" required>
                    <input type="email" placeholder="Email*" name="email" class="form-control margin-top-10" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </div>
            </form>
        </div>
    </div>
</div>
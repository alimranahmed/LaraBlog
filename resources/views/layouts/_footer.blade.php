<footer class="container-fluid border-top">
    <div class="row purple-text text-darken-4">
        <div class="col-sm-2">© 2016 Al- Imran Ahmed</div>
        @if(!Auth::check())
            <div class="col-sm-2">
                <span class="pointer" data-toggle="modal" data-target="#subscribe-form">Subscribe</span>
            </div>
            <div class="col-sm-1 col-sm-offset-7">
                <a href="{{route('login-form')}}" class="text-grey">Manage</a>
            </div>
        @endif
    </div>

    <!-- Subscription form Modal -->
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
                        <input type="text" placeholder="Name*" name="name" class="form-control">
                        <input type="email" placeholder="Email*" name="email" class="form-control margin-top-10">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</footer>
</div>
<script src="{{asset("js/vue.js")}}"></script>
<script src="{{asset("js/app.js")}}" type="text/javascript"></script>
<script src="{{asset("js/highlight.js")}}"></script>
<script>hljs.initHighlightingOnLoad();</script>
@yield('inPageJS')
</body>
</html>
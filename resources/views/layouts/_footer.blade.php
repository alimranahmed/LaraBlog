<footer class="container-fluid border-top">
    <div class="row purple-text text-darken-4">
        <div class="col-sm-2">© 2016 Al- Imran Ahmed</div>
        @if(!Auth::check())
            <div class="col-sm-1">
                <span class="pointer" data-toggle="modal" data-target="#subscribe-form">Subscribe</span>
            </div>
            <div class="col-sm-1">
                <span class="pointer" data-toggle="modal" data-target="#feedback-form">Feedback</span>
            </div>
            <div class="col-sm-1 col-sm-offset-7">
                <a href="{{route('login-form')}}" class="text-grey">Manage</a>
            </div>
        @endif
    </div>

    @include("layouts._modal_subscribe_form")
    @include("layouts._modal_feedback_form")
</footer>
</div>
<script src="{{asset("js/vue.js")}}"></script>
<script src="{{asset("js/app.js")}}" type="text/javascript"></script>
<script src="{{asset("js/highlight.js")}}"></script>
<script>hljs.initHighlightingOnLoad();</script>
@yield('inPageJS')
</body>
</html>
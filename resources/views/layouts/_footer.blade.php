<footer class="container-fluid border-top">
    <div class="row purple-text text-darken-4 footer">
        <div class="col-sm-2 text-center">Powered by
            <a href="https://github.com/alimranahmed/LaraBlog" target="_blank">LaraBlog</a>
        </div>
        <div class="col-sm-2 text-center">© {{date('Y').' '.$globalConfigs->copyright_owner}} </div>
        @if(!Auth::check())
            <div class="col-sm-1 text-center">
                <span class="pointer text-info" data-toggle="modal" data-target="#subscribe-form">Subscribe</span>
            </div>
            <div class="col-sm-1 text-center">
                <span class="pointer text-info" data-toggle="modal" data-target="#feedback-form">Feedback</span>
            </div>
            <div class="col-sm-1 col-sm-offset-5 text-center">
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
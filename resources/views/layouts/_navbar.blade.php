<nav class="navbar navbar-default no-margin-bottom" id="top-navbar">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('home')}}">{{$globalConfigs->site_name}}</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="{{request()->is('article*') ? "active":""}}">
                    <a href="{{route('articles')}}">Articles </a>
                </li>
                <li class="dropdown {{request()->is('category/*') ? "active":""}}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Categories <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($navCategories as $category)
                            <li><a href="{{route('articles-by-category', $category->alias)}}">{{$category->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
                @if(auth()->check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">{{auth()->user()->name}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('user-profile')}}">Profile</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#changePassword">Change Password</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('logout')}}">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
            <form class="navbar-form navbar-right" id="#searchBox" action="{{route('search-article')}}" method="get">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search" name="query_string">
                </div>
            </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

{{--Change password modal--}}
<div class="modal fade" tabindex="-1" role="dialog" id="changePassword">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change Password</h4>
            </div>
            <form action="{{route('change-password')}}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Old Password</label>
                        <input type="password" class="form-control" name="old_password" id="#old-password">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control" name="new_password" id="#new-password">
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" class="form-control" name="confirm_new_password" id="#confirm-new-password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Change</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
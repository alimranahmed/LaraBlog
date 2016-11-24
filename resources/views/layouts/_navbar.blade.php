<nav class="navbar navbar-default navbar-fixed-top">
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
            <a class="navbar-brand" href="{{route('home')}}">Al- Imran Ahmed</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="{{Request::is('article*') ? "active":""}}">
                    <a href="{{route('articles')}}">Articles </a>
                </li>
                <li class="dropdown {{Request::is('category/*') ? "active":""}}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Categories <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($categories as $category)
                            <li><a href="{{route('articles-by-category', $category->alias)}}">{{$category->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
                @if(Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">{{Auth::user()->name}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Settings</a></li>
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
<nav class="navbar navbar-default sidebar">
    <div>
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {{--<a class="navbar-brand" href="#">Al- Imran Ahmed</a>--}}
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="sidebar">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="#">
                        <i class="fa fa-dashboard"></i>
                        <span class="hidden-sm">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin-articles')}}">
                        <i class="fa fa-file-text"></i>
                        <span class="hidden-sm">Articles</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="fa fa-database"></span>
                        <span class="hidden-sm">Categories</span>
                    </a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
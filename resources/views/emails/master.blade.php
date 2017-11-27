<!doctype html>
<html lang="en">
<body>
<div style="border: 1px solid #d1ebd3; padding: 15px 40px">
    @yield('content')
</div>
<div style="background: #d1ebd3; padding: 15px; text-align: center">
    © {{date('Y').' '.$globalConfigs->copyright_owner}}
</div>
</body>
</html>
<!doctype html>
<html lang="en">
<body>
<div style="border: 1px solid #ddd; padding: 15px 40px">
    @yield('content')
</div>
<div style="background: #ddd; padding: 15px; text-align: center">
    © {{date('Y').' '.$globalConfigs->copyright_owner}}
</div>
</body>
</html>
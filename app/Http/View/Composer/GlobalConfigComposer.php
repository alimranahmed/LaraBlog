<?php


namespace App\Http\View\Composer;

use App\Models\Config;
use Illuminate\View\View;

class GlobalConfigComposer
{
    protected $globalConfigs;

    public function __construct()
    {
        $this->globalConfigs = Config::allFormatted();
    }

    public function compose(View $view)
    {
        $view->with('globalConfigs', $this->globalConfigs);
    }
}

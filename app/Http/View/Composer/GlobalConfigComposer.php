<?php

namespace App\Http\View\Composer;

use App\Models\Config;
use Illuminate\View\View;
use stdClass;

class GlobalConfigComposer
{
    protected stdClass $globalConfigs;

    public function __construct()
    {
        $this->globalConfigs = Config::allFormatted();
    }

    public function compose(View $view): void
    {
        $view->with('globalConfigs', $this->globalConfigs);
    }
}

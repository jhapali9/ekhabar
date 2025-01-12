<?php

namespace App\Http\View\Composers;

use App\Services\WidgetService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Sentinel;

class WidgetComposer
{
    protected $widgetService;

    public function __construct(WidgetService $widgetService)
    {
        $this->widgetService = $widgetService;
    }

    public function compose(View $view)
    {
        if (Sentinel::check()):
            $widgets = $this->widgetService->getWidgetDetails();
        else:
            $widgets = $this->widgetService->getWidgetDetails();
        endif;
        $view->with('widgets', $widgets);
    }
}

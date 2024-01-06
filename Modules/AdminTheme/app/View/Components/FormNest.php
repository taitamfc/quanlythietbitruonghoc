<?php

namespace Modules\AdminTheme\app\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class FormNest extends Component
{
    protected $model;
    protected $item;
    protected $showAll;
    /**
     * Create a new component instance.
     */
    public function __construct($model,$status = null,$showAll = 0)
    {
        $this->model = $model = Nest::class;
        $this->status = $status;
        $this->showAll = $showAll;
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        $params = [
            'model' => $this->model,
            'status' => $this->status,
            'showAll' => $this->showAll,
        ];
        return view('admintheme::components.form-nest',$params);
    }
}

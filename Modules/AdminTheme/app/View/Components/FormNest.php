<?php

namespace Modules\AdminTheme\app\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Nest;

class FormNest extends Component
{
    protected $model;
    protected $item;
    protected $showAll;
    /**
     * Create a new component instance.
     */
    public function __construct($model,$nest_id = null,$showAll = 0)
    {
        $this->model = $model = Nest::class;
        $this->nest_id = $nest_id;
        $this->showAll = $showAll;
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        $params = [
            'model' => $this->getModel(),
            'nest_id' => $this->nest_id,
            'showAll' => $this->showAll,
        ];
        return view('admintheme::components.form-nest', $params);
    }

    public function getModel()
    {
        return $this->model;
    }
}

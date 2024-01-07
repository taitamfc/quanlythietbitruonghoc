<?php

namespace Modules\AdminTheme\app\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Group;

class FormGroup extends Component
{
    protected $model;
    protected $item;
    protected $showAll;
    /**
     * Create a new component instance.
     */
    public function __construct($model,$group_id = null,$showAll = 0)
    {
        $this->model = $model = Group::class;
        $this->group_id = $group_id;
        $this->showAll = $showAll;
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        $params = [
            'model' => $this->getModel(),
            'group_id' => $this->group_id,
            'showAll' => $this->showAll,
        ];
        return view('admintheme::components.form-group', $params);
    }

    public function getModel()
    {
        return $this->model;
    }
}

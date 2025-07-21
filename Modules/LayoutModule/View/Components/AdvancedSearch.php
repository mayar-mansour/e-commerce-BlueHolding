<?php

namespace Modules\LayoutModule\View\Components;

use Illuminate\View\Component;
use Modules\ClubModule\Entities\Club;

class AdvancedSearch extends Component
{
    public $fields;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $clubs = Club::all();
        return view('layoutmodule::components.advancedsearch',[
            'clubs' => $clubs ,
        ]);
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select2 extends Component
{
    public $options;

    /**
     * Create a new component instance.
     *
     * @param mixed $options
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('components.select2');
    }
}

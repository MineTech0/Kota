<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Panel extends Component
{
    public $header;
    public function __construct($header)
    {
        $this->header = $header;
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.panel');
    }
}

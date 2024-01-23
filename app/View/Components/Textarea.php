<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public $default;
    /**
     * Create a new component instance.
     */
    public function __construct($default = 'Hello World')
    {
        $this->default = $default;
        // dd($defaultvalue);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.textarea', ["default" => $this->default]);
    }
}

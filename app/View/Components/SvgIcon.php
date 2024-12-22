<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SvgIcon extends Component
{
    public $color, $type;
    
    public function __construct($type, $color="black")
    {
        $this->color = $color;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $icon_paths = config('svg-icons');
        $path = $icon_paths[$this->type] ?? null;
        // dd($path);
        return view('components.svg-icon', ['path' => $path]);
    }
}

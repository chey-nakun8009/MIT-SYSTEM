<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public string $name;
    public string $label;
    public string $type;
    public mixed $value;
    public bool $required;
    public string $class;

    public function __construct(
        string $name,
        string $label,
        string $type = 'text',
        mixed $value = null,
        bool $required = false,
        string $class = 'col-12'
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->value = $value;
        $this->required = $required;
        $this->class = $class;
    }

    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}

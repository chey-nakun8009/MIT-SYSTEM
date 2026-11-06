<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class EmptyRow extends Component
{
    public function __construct(
        public int $colspan = 7,
        public string $message = 'មិនមានទិន្ន័យបង្ហាញ!',
    ) {}

    public function render(): View
    {
        return view('components.empty-row');
    }
}

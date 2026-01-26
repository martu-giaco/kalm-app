<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RoutineCard extends Component
{
    public $rutina;
    public $visibleProducts;
    public $remainingProducts;

    public function __construct($rutina)
    {
        $this->rutina = $rutina;

        $products = $rutina->assignedProducts;

        $this->visibleProducts = $products->take(3);
        $this->remainingProducts = max(0, $products->count() - 3);
    }

    public function render()
    {
        return view('components.routine-card');
    }
}

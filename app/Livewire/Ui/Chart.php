<?php

namespace App\Livewire\Ui;

use Livewire\Component;
use Livewire\Attributes\On;

class Chart extends Component
{
    public $chartUrl = 'http://amc-tensor1.ucdenver.pvt:8004/ocpu/library/voyageneR/R/plotDimReduction/json';

    #[On('updateChart')]
    public function updateChart()
    {
        $this->render();
    }

    public function render()
    {
        return view('livewire.ui.chart');
    }
}

<?php

namespace App\Livewire\Ui\Controls;

use Livewire\Component;

class ChartMode extends Component
{
    public function select($option)
    {
        $this->dispatch('updateChart', chart_type: $option, color_by: 'SPP1');
    }

    public function render()
    {
        return view('livewire.ui.controls.chart-mode');
    }
}

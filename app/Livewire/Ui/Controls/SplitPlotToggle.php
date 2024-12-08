<?php

namespace App\Livewire\Ui\Controls;

use Livewire\Component;
use Livewire\Attributes\On;

class SplitPlotToggle extends Component
{
    public $chartMode = false;
    public $show = false;

    #[On('color-by-changed')]
    public function toggle($color_by)
    {
        $special_categories = ['celltypes', 'level', 'sample_id', 'seurat_clusters'];

        if (in_array($color_by, $special_categories)) {
            $this->show = true;
            $this->dispatch('hide-gene-dropdown');
        } else {
            $this->show = false;
        }
    }

    public function updateChart()
    {
        $this->dispatch('updateChart', chartMode: $this->chartMode);
    }

    public function render()
    {
        return view('livewire.ui.controls.split-plot-toggle');
    }
}

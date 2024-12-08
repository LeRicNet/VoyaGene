<?php

namespace App\Livewire\Ui;

use Livewire\Component;
use Livewire\Attributes\On;

class ControlPanel extends Component
{
    public $chartMode = false;
    public $hideSidebar = false;
    public $chartUrl = 'http://amc-tensor1.ucdenver.pvt:8004/ocpu/library/voyageneR/R/plotDimReduction/json';
    public $show_gene_dropdown = false;

    public function showSidebar()
    {
        $this->hideSidebar = false;
        $this->updateChart();
    }

    public function closeSidebar()
    {
        $this->hideSidebar = true;
        $this->updateChart();
    }

    #[On('show-gene-dropdown')]
    public function showGeneDropdown()
    {
        $this->show_gene_dropdown = true;
    }

    #[On('hide-gene-dropdown')]
    public function hideGeneDropdown()
    {
        $this->show_gene_dropdown = false;
    }

    public function updateChart()
    {
        $this->dispatch('updateChart', chartMode: $this->chartMode);
    }

    public function render()
    {
        return view('livewire.ui.control-panel');
    }
}

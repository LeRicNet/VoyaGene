<?php

namespace App\Livewire\Ui\Controls;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class GeneDropdown extends Component
{
    public $options = [];
    public $search = '';
    public $selectedOption = null;
    public $url = 'http://amc-tensor1.ucdenver.pvt:8004/ocpu/library/voyageneR/data/available_genes/json';

    public function mount()
    {
        $this->fetchOptions();
    }

    public function fetchOptions()
    {
        $response = Http::get($this->url);
        if ($response->successful()) {
            $this->options = $response->json();
        }
    }

    public function select($option) {
        $this->selectedOption = $option;
        $this->search = $option;
        $this->dispatch('updateChart', color_by: $this->selectedOption);
//        dd($this);
    }

    public function render()
    {
        return view('livewire.ui.controls.gene-dropdown');
    }
}

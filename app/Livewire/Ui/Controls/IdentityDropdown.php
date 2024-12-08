<?php

namespace App\Livewire\Ui\Controls;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class IdentityDropdown extends Component
{

    public $options = [];
    public $selectedOption = null;
    public $url = 'http://amc-tensor1.ucdenver.pvt:8004/ocpu/library/voyageneR/R/getIdentities/json';

    public function mount()
    {
        $this->fetchOptions();
    }

    public function select($option) {
        $this->selectedOption = $option;
        $this->dispatch('color-by-changed', color_by: $this->selectedOption);
        if ($this->selectedOption === 'Gene Expression') {
            $this->dispatch('show-gene-dropdown');
        } else {
            $this->dispatch('hide-gene-expression');
            $this->dispatch('updateChart', color_by: $this->selectedOption);
        }
    }

    public function fetchOptions()
    {
        $response = Http::post($this->url);

        if ($response->successful()) {
            $this->options = array_map(function($item) {
                return $item['identities'];
            }, $response->json());
        }
    }
    public function render()
    {
        return view('livewire.ui.controls.identity-dropdown');
    }
}

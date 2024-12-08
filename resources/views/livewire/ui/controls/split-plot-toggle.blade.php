<div>
    @if($show)
        <input type="checkbox"
               wire:model="chartMode"
               wire:click="updateChart"
               class="form-checkbox h-5 w-5 text-indigo-600 transition duration-300 ease-in-out">
        <label class="ml-2">Split Plot</label>
    @endif
</div>
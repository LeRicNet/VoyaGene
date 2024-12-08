<div class="w-full max-w-xs mx-auto">
    <label for="chart-mode-dropdown" class="block text-sm font-medium text-gray-300">Chart Mode</label>
    <select id="chart-mode-dropdown"
            wire:change="select($event.target.value)"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base bg-gray-800
            border-gray-600 text-white focus:outline-none focus:ring-indigo-500
            focus:border-indigo-500 sm:text-sm rounded-md">
        <option value="UMAP" selected>UMAP</option>
        <option value="expression">Gene Expression</option>
    </select>
</div>
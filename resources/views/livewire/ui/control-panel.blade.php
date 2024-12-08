<div>
        @if( $hideSidebar )
                <div class="h-screen flex items-center justify-center">
                        <button class="absolute -left-20 transform rotate-[90deg] font-medium text-lg text-white cursor-pointer border border-white rounded-t px-2" wire:click="showSidebar">
                                Show Control Panel
                        </button>
                </div>

        @else
        <div @class(['h-screen bg-gray-900 w-80 border border-gray-700 p-4 z-[99999] text-white'])>
            <div class="p-2">
                <div class="flex flex-row w-full items-center justify-between">
                    <div class="text-lg font-semibold">Voyagene</div>
                    <div>
                        <button wire:click="closeSidebar" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded transition duration-300">
                            Hide
                        </button>
                    </div>
                </div>

                <div class="my-8">
                    <livewire:ui.controls.dataset />
                </div>

                <div class="my-8">
                    <livewire:ui.controls.chart-mode />
                </div>

                <div class="my-8">
                    <div>
                        <input type="checkbox" wire:model="chartMode" wire:click="updateChart" class="form-checkbox h-5 w-5 text-indigo-600 transition duration-300 ease-in-out">
                        <label class="ml-2">Chart Mode</label>
                    </div>
                </div>

                <div class="my-8">
                    <livewire:ui.controls.identity-dropdown />
                </div>

                @if($show_gene_dropdown)
                    <div class="my-8">
                        <livewire:ui.controls.gene-dropdown />
                    </div>
                @endif
            </div>
        </div>

        @endif

    @script
            <script>
                $wire.on('updateChart', (e) => {
                    let url = '{{ $chartUrl }}';
                    console.log(`chart type: ${e.chart_type}, split by celltype: ${e.chartMode}, color by: ${e.color_by}`);
                    console.log(e);
                    // const chart_type = e.chart_type || 'UMAP';
                    // const color_by = e.color_by || 'celltypes';
                    window.sessionConfig.chart_type = e.chart_type || window.sessionConfig.chart_type
                    window.sessionConfig.color_by = e.color_by || window.sessionConfig.color_by

                    if (window.sessionConfig.chart_type == 'expression') {
                        url = url.replace('plotDimReduction', 'plotViolin');
                    }

                    fetchChartData(url, window.sessionConfig.color_by)
                        .then(data => {
                            if (window.sessionConfig.chart_type == 'UMAP') {
                                if (e.chartMode == true) {
                                    splitChart(data);
                                } else {
                                    singleChart(data);
                                }
                            } else if (window.sessionConfig.chart_type == 'expression') {
                                scatterChart(data, window.sessionConfig.color_by)
                            }
                        });
                })
            </script>
    @endscript

</div>

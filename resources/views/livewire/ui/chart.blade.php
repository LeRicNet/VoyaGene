<div style="height: 100vh;">
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div id="chartsContainer" class="flex justify-center gap-4 p-4 h-full" style="flex-wrap: wrap; height: 100%">
    </div>

    @script
    <script>
        const url = '{{ $chartUrl }}';

        fetchChartData(url)
            .then(data => {
                singleChart(data);
            });
    </script>
    @endscript
</div>

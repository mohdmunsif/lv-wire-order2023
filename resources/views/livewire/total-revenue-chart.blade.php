<div wire:poll.60="update">
    <div wire:ignore>
        <div id="chart" style="height: 320px;"></div>
    </div>
</div>

@push('js')
    {{-- <script>
        const chart = new Chartisan({
            el: '#chart',
            url: "@chart('total_revenue_chart')",
            hooks: new ChartisanHooks()
                .beginAtZero()
                .colors()
                .borderColors()
                .datasets([{ type: 'line', fill: false }, 'bar'])
                .custom(function ({ data, merge }) {
                    return merge(data, {
                        options: {
                            tooltips: {
                                callbacks: {
                                    label: function (t) {
                                        return (
                                            "$" + // currency code of choice
                                            t.yLabel
                                                .toFixed(2) // 2 decimals with trailing 0
                                                .toString()
                                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                        );
                                    },
                                },
                            },
                        },
                    });
                }),
        });

        window.livewire.on('chartUpdate', () => {
            chart.update({ url: "@chart('total_revenue_chart')", background: true })
        });
    </script> --}}
@endpush

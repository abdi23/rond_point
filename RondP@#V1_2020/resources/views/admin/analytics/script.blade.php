<script>
    function sessionByDevice(day) {
        $.ajax({
            url: "{{ route('device.analytics') }}",
            method: "GET",
            data: {
                'periode': day
            }
        }).done(function (data) {
            window.location.reload();
        });
    }

    function visitorPageView(day) {
        $.ajax({
            url: "{{ route('visitorpageview.analytics') }}",
            method: "GET",
            data: {
                'periode': day
            }
        }).done(function (data) {
            window.location.reload();
        });
    }
</script>
@if(env('ANALYTICS_VIEW_ID'))
    @can('read-analytics')
        @if(Settings::check_connection())
            @if(Settings::checkCredentialFileExists())
                <!-- Charting library -->
                <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
                <!-- Chartisan -->
                <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
                <script>
                    const chart = new Chartisan({
                        el: '#chart',
                        url: "@chart('chart_route_name')",
                        hooks: new ChartisanHooks()
                            .colors(['#27ae60', '#7CD6FD'])
                            .tooltip()
                            .datasets('line')
                            .legend({ bottom: 0 })
                    });

                    @empty($devices)
                    const deviceChart = new Chartisan({
                        el: '#deviceChart',
                        url: "@chart('device_chart')",
                        hooks: new ChartisanHooks()
                            .colors(['#C9C9C9'])
                            .axis(false)
                            .tooltip()
                            .datasets('pie')
                    });
                    @else
                    const deviceChart = new Chartisan({
                        el: '#deviceChart',
                        url: "@chart('device_chart')",
                        hooks: new ChartisanHooks()
                            .colors(['#27ae60', '#7CD6FD', '#018786', '#C9C9C9'])
                            .axis(false)
                            .tooltip()
                            .datasets('pie')
                    });
                    @endempty
                </script>
            @endif
        @endif
    @endcan
@endif

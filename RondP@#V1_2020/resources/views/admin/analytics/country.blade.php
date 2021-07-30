<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Sessions by country') }}</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Country') }}</th>
                    <th>{{ __('Sessions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($topCountry as $i => $v)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $v['country'] }}</td>
                        <td>{{ $v['sessions'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

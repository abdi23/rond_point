<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Visitor & Pageview') }}</h3>
        <div class="card-tools">
            <div class="btn-group">
                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                    {{ $label_day_visitor }}
                </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu" id="session_by_device">
                    <a href="javascript:;" class="dropdown-item choice" onclick="visitorPageView(0);">{{ __('Today') }}</a>
                    <a href="javascript:;" class="dropdown-item choice" onclick="visitorPageView(1);">{{ __('Yesterday') }}</a>
                    <a href="javascript:;" class="dropdown-item choice" onclick="visitorPageView(7);">{{ __('Last 7 days') }}</a>
                    <a href="javascript:;" class="dropdown-item choice" onclick="visitorPageView(28);">{{ __('Last 28 days') }}</a>
                    <a href="javascript:;" class="dropdown-item choice" onclick="visitorPageView(90);">{{ __('Last 90 days') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <!-- Chart's container -->
        <div id="chart" style="height: 300px;"></div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                    <h5 class="description-header">{{ $pageviews_this_year }}</h5>
                    <span class="description-text">PAGEVIEWS ({{ \Carbon\Carbon::now()->year }})</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                    <h5 class="description-header">{{ $visitors_this_year }}</h5>
                    <span class="description-text">VISITORS ({{ \Carbon\Carbon::now()->year }})</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                    <h5 class="description-header">{{ $pageviews }}</h5>
                    <span class="description-text">PAGEVIEWS</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-6">
                <div class="description-block">
                    <h5 class="description-header">{{ $visitors }}</h5>
                    <span class="description-text">VISITORS</span>
                </div>
                <!-- /.description-block -->
            </div>
        </div>
        <!-- /.row -->
    </div>
</div>

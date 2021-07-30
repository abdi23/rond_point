<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use Spatie\Analytics\AnalyticsFacade as Analytics;
use Spatie\Analytics\Period;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return Renderable|Application|Factory|View
     */
    public function __invoke(Request $request)
    {
        //variable for analytics
        $totalVP = null;
        $activeUsers = null;
        $devices = null;
        $mostVisited = null;
        $topBrowsers = null;
        $topOperatingSystem = null;
        $topCountry = null;
        $devices = null;
        $new_visitors = null;
        $visitors_this_year = null;
        $pageviews = null;
        $pageviews_this_year = null;
        $visitors = null;
        $col = null;
        $day = null;
        $label_day = null;
        $label_day_visitor = null;

        //if internet is available data will be displayed otherwise it will be null
        $connection = false;
        if (Settings::check_connection()) {
            if (env('ANALYTICS_VIEW_ID') != "") {

                $day = $request->session()->has('session_device_analytics') ? session('session_device_analytics') : 7;
                $day_visitor_pageviews = $request->session()->has('session_visitor_pageview_analytics') ? session('session_visitor_pageview_analytics') : 7;

                $label_day = $this->label($request->session()->has('session_device_analytics'), $day);
                $label_day_visitor = $this->label($request->session()->has('session_visitor_pageview_analytics'), $day_visitor_pageviews);


                //display analytics
                $connection = true;
                $activeUsers = $this->fetchOnlineUsers();
                $mostVisited = Analytics::fetchMostVisitedPages(Period::days($day), 8);
                $topBrowsers = Analytics::fetchTopBrowsers(Period::days($day), 8);
                $topOperatingSystem = $this->fetchTopOperatingSystem(Period::days($day), 8);
                $topCountry = $this->fetchTopCountry(Period::days($day), 8);
                $visitors_this_year = $this->visitorsThisYear();
                $pageviews_this_year = $this->pageViewsThisYear();
                $new_visitors = $this->newVisitors(Period::days(7));
                $visitors = $this->visitors(Period::days($day_visitor_pageviews));
                $pageviews = $this->pageViews(Period::days($day_visitor_pageviews));
                $devices = Arr::collapse($this->fetchTopDevice(Period::days($day)));
                $number_devices = $devices ? count($devices) : 12;
                $col = 12 / $number_devices;
            }
        }

        return view('admin.dashboard',
            compact('activeUsers',
                'mostVisited',
                'topBrowsers',
                'topOperatingSystem',
                'topCountry',
                'visitors_this_year',
                'pageviews_this_year',
                'visitors',
                'pageviews',
                'connection',
                'devices',
                'col',
                'day',
                'label_day',
                'label_day_visitor',
                'new_visitors'
            ));
    }

    /**
     * @return mixed
     */
    public function fetchOnlineUsers()
    {
        $analytics = Analytics::getAnalyticsService();
        return $analytics->data_realtime
            ->get(
                'ga:' . env('ANALYTICS_VIEW_ID'),
                'rt:activeVisitors'
            )
            ->totalsForAllResults['rt:activeVisitors'];
    }

    /**
     * @param Period $period
     * @param int $maxResults
     * @return Collection
     */
    public function fetchTopOperatingSystem(Period $period, int $maxResults = 10)
    {
        $response = Analytics::performQuery(
            $period,
            'ga:sessions',
            [
                'dimensions' => 'ga:operatingSystem,ga:operatingSystemVersion',
                'sort' => '-ga:sessions',
            ]
        );

        $topOSs = collect($response['rows'] ?? [])->map(function (array $osRow) {
            return [
                'os' => $osRow[0],
                'version' => $osRow[1],
                'sessions' => (int)$osRow[2],
            ];
        });

        if ($topOSs->count() <= $maxResults) {
            return $topOSs;
        }

        return $this->summarizeTopOperatingSystem($topOSs, $maxResults);
    }

    /**
     * @param Collection $topOSs
     * @param int $maxResults
     * @return Collection
     */
    protected function summarizeTopOperatingSystem(Collection $topOSs, int $maxResults)
    {
        return $topOSs
            ->take($maxResults - 1)
            ->push([
                'os' => 'Others',
                'version' => '-',
                'sessions' => $topOSs->splice($maxResults - 1)->sum('sessions'),
            ]);
    }

    /**
     * @param Period $period
     * @param int $maxResults
     * @return Collection
     */
    public function fetchTopCountry(Period $period, int $maxResults = 10)
    {
        $response = Analytics::performQuery(
            $period,
            'ga:sessions',
            [
                'dimensions' => 'ga:country',
                'sort' => '-ga:sessions',
            ]
        );

        $topCountrys = collect($response['rows'] ?? [])->map(function (array $countryRow) {
            return [
                'country' => $countryRow[0],
                'sessions' => (int)$countryRow[1],
            ];
        });

        if ($topCountrys->count() <= $maxResults) {
            return $topCountrys;
        }

        return $this->summarizeTopCountry($topCountrys, $maxResults);
    }

    /**
     * @param Collection $topCountrys
     * @param int $maxResults
     * @return Collection
     */
    protected function summarizeTopCountry(Collection $topCountrys, int $maxResults)
    {
        return $topCountrys
            ->take($maxResults - 1)
            ->push([
                'country' => 'Others',
                'sessions' => $topCountrys->splice($maxResults - 1)->sum('sessions'),
            ]);
    }

    /**
     * @return mixed
     */
    public function fetchTotalVisitors()
    {
        $startDate = Carbon::create(2020, 01, 01, 0, 0, 0);
        $period = Period::create($startDate, Carbon::now());
        return $this->fetchTotalVisitorsAndPageViews($period)->sum('visitors');
    }

    /**
     * @param Period $period
     * @return mixed
     */
    public function fetchTotalPageViews(Period $period)
    {
        return $this->fetchTotalVisitorsAndPageViews($period)->sum('pageViews');
    }

    /**
     * @return mixed
     */
    public function visitorsThisYear()
    {
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now();
        $period_this_year = Period::create($startDate, $endDate);
        return $this->fetchTotalVisitorsAndPageViews($period_this_year)->sum('visitors');
    }

    /**
     * @return mixed
     */
    public function pageViewsThisYear()
    {
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now();
        $period_this_year = Period::create($startDate, $endDate);
        return $this->fetchTotalVisitorsAndPageViews($period_this_year)->sum('pageViews');
    }

    /**
     * @param Period $period
     * @return mixed
     */
    public function fetchTotalVisitorsAndPageViews(Period $period)
    {
        return Analytics::fetchTotalVisitorsAndPageViews($period);
    }

    /**
     * @param Period $period
     * @return Collection
     */
    public function fetchTopDevice(Period $period)
    {
        $response = Analytics::performQuery(
            $period,
            'ga:users',
            [
                'dimensions' => 'ga:deviceCategory'
            ]
        );

        return collect($response['rows'] ?? [])->map(function (array $deviceRow) {
            return [$deviceRow[0] => $deviceRow[1]];
        });
    }

    /**
     * @param Period $period
     * @return array[]
     */
    public function fetchUserTypes(Period $period)
    {
        return Analytics::fetchUserTypes($period);
    }

    /**
     * @param Period $period
     * @return mixed
     */
    public function newVisitors(Period $period)
    {
        $response = Analytics::fetchUserTypes($period);
        return $response[0]['sessions'];
    }

    /**
     * @param Period $period
     * @return mixed
     */
    public function visitors(Period $period)
    {
        return $this->fetchTotalVisitorsAndPageViews($period)->sum('visitors');
    }

    /**
     * @param Period $period
     * @return mixed
     */
    public function PageViews(Period $period)
    {
        return $this->fetchTotalVisitorsAndPageViews($period)->sum('pageViews');
    }

    /**
     * @param Period $period
     * @return Collection
     */
    public function fetchVisitors(Period $period)
    {
        $response = Analytics::performQuery(
            $period,
            'ga:users',
            ['dimensions' => 'ga:date']
        );
        return collect($response['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'date' => Carbon::createFromFormat('Ymd', $dateRow[0]),
                'visitors' => (int)$dateRow[1],
            ];
        });
    }

    /**
     * @param $session
     * @param $day
     * @return string
     */
    public function label($session, $day)
    {
        $label = "In 7 days";
        if ($session) {
            if ($day == 0) {
                $label = "In Today";
            } else if ($day == 1) {
                $label = "In Yesterday";
            } else if ($day == 7) {
                $label = "In 7 days";
            } else if ($day == 28) {
                $label = "In 28 days";
            } else if ($day == 90) {
                $label = "In 90 days";
            }
        }

        return $label;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MagzExports;
use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use App\Imports\MagzImport;
use App\Models\Post;
use App\Models\Setting;
use Brotzka\DotenvEditor\DotenvEditor;
use Brotzka\DotenvEditor\Exceptions\DotEnvException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url as SpatieURL;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class SettingController extends Controller
{
    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        if (!File::exists(storage_path('app/public/assets'))) {
            File::makeDirectory(storage_path('app/public/assets'));
        }
        $this->middleware('permission:read-settings', ['only' => ['index', 'setting']]);
        $this->middleware('permission:update-settings', [
            'only' => ['updateSettings', 'changeMaintenance', 'changeRegisterMember', 'settingUpdate']
        ]);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get_setting($name)
    {
        return Setting::whereName($name)->first()->value;
    }

    /**
     * @return array
     */
    public function arraySettings()
    {
        return [
            'company_name'       => $this->get_setting('company_name'),
            'sitename'           => $this->get_setting('sitename'),
            'siteurl'            => $this->get_setting('siteurl'),
            'siteemail'          => $this->get_setting('siteemail'),
            'sitephone'          => $this->get_setting('sitephone'),
            'street'             => $this->get_setting('street'),
            'city'               => $this->get_setting('city'),
            'postal_code'        => $this->get_setting('postal_code'),
            'state'              => $this->get_setting('state'),
            'country'            => $this->get_setting('country'),
            'fulladdress'        => $this->get_setting('fulladdress'),
            'sitedescription'    => $this->get_setting('sitedescription'),
            'contactdescription' => $this->get_setting('contactdescription'),
            'metakeyword'        => $this->get_setting('metakeyword'),
            'maintenance'        => $this->get_setting('maintenance'),
            'register'           => $this->get_setting('register'),
            'favicon'            => $this->get_setting('favicon'),
            'logowebsite'        => $this->get_setting('logowebsite'),
            'logowebsite_footer' => $this->get_setting('logowebsite_footer'),
            'ogimage'            => $this->get_setting('ogimage'),
            'logodashboard'      => $this->get_setting('logodashboard'),
            'logoauth'           => $this->get_setting('logoauth'),
            'facebook'           => $this->get_setting('facebook'),
            'twitter'            => $this->get_setting('twitter'),
            'youtube'            => $this->get_setting('youtube'),
            'instagram'          => $this->get_setting('instagram'),
            'linkedin'           => $this->get_setting('linkedin'),
            'telegram'           => $this->get_setting('telegram'),
            'whatsapp'           => $this->get_setting('whatsapp'),
            'googleanalyticsid'  => $this->get_setting('googleanalyticsid'),
            'analytics_view_id'  => $this->get_setting('analytics_view_id'),
            'credentials_file'   => $this->get_setting('credentials_file'),
            'googlemapcode'      => $this->get_setting('googlemapcode'),
            'publisherid'        => $this->get_setting('publisherid'),
            'disqusshortname'    => $this->get_setting('disqusshortname'),
            'mailchimp'          => $this->get_setting('mailchimp'),
            'permalink_type'     => $this->get_setting('permalink_type'),
            'permalink'          => $this->get_setting('permalink'),
            'permalink_old'      => $this->get_setting('permalink_old_custom'),
        ];
    }

    /**
     * @return Application|Factory|View|Application|Factory|View
     */
    public function setting()
    {
        $arraySettings = $this->arraySettings();

        $dir = Settings::get('current_theme_dir');
        $credit_footer = File::get(resource_path('views/frontend/'.$dir.'/inc/_credit-footer.blade.php'));

        $settings = (object) $arraySettings;

        $check = $settings->maintenance === 'y' ? 'checked' : '';
        $register = $settings->register === 'y' ? 'checked' : '';

        if ($settings->analytics_view_id) {
            $analytics_view_id = $settings->analytics_view_id;
        } else {
            $env = new DotenvEditor();
            if(!$env->keyExists("ANALYTICS_VIEW_ID")) {
                $env->addData([
                    'ANALYTICS_VIEW_ID' => ''
                ]);
            }
            $analytics_view_id = $env->getValue("ANALYTICS_VIEW_ID");
        }

        $logowebsite        = $this->getLogo($settings->logowebsite);
        $logowebsite_footer = $this->getLogo($settings->logowebsite_footer);
        $favicon            = $this->getLogo($settings->favicon);
        $ogimage            = $this->getLogo($settings->ogimage);
        $logodashboard      = $this->getLogo($settings->logodashboard);
        $logoauth           = $this->getLogo($settings->logoauth);

        return view('admin.setting.index', compact(
            'settings',
            'check',
            'register',
            'credit_footer' ,
            'logowebsite',
            'logowebsite_footer',
            'favicon',
            'logoauth',
            'logodashboard',
            'ogimage',
            'analytics_view_id'
        ));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function updateSettings(Request $request)
    {
        $this->authorize('update-settings');

        if (request('name') == "") {
            return response()->json(['failed' => __('Field cannot be empty!')]);
        } else {
            Setting::where('name', request('name'))
                ->update(['value' => request('value')]);
            return response()->json(['success' => __('Saved successfully')]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changeMaintenance(Request $request)
    {
        Setting::where('name', 'maintenance')
            ->update(['value' => request('active')]);
        if (request('active') === 'y') {
            $msg = __('Mode Maintenance Enabled!');
        } else {
            $msg = __('Mode Maintenance Disabled!');
        }

        return response()->json(['success' => $msg]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changeRegisterMember(Request $request)
    {
        if(!Auth::User()->hasRole(['superadmin', 'admin'])) {
            return response()->json(['abort' => __('Unauthorized action!')]);
        }
        Setting::where('name', 'register')
            ->update(['value' => request('active')]);
        if (request('active') === 'y') {
            $msg = __('Register Member Enabled!');
        } else {
            $msg = __('Register Member Disabled!');
        }

        return response()->json(['success' => $msg]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException|DotEnvException
     */
    public function settingUpdate(Request $request)
    {
        $this->authorize('update-settings');
        $validator = Validator::make(request()->all(), [
            'company_name' => Rule::requiredIf(request()->has('web_information')),
            'sitename'     => Rule::requiredIf(request()->has('web_information')),
            'siteurl'      => Rule::requiredIf(request()->has('web_information')),
            'favicon'      => 'dimensions:max_width=256,max_height=256|mimes:jpeg,png,ico',
            'logowebsite'  => 'dimensions:max_width=800,max_height=800|image|mimes:jpeg,png',
            'ogimage'      => 'dimensions:max_width=1484,max_height=1200|image|mimes:jpeg,png'
        ]);

        if (request()->has('site_logo')) {
            if ($validator->fails()) {
                return redirect()->route('settings.index')->with('error', $validator->errors()->first());
            }
        } else {
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }
        }

        if (request()->has('web_information')) {

            if (request('credit_footer')) {
                $dir = Settings::get('current_theme_dir');
                File::put(resource_path('views/frontend/'.$dir.'/inc/_credit-footer.blade.php'), request('credit_footer'));
            }

            $arrayValues = [
                ['name' => 'company_name', 'value' => request('company_name')],
                ['name' => 'sitename', 'value' => request('sitename')],
                ['name' => 'siteurl', 'value' => request('siteurl')],
                ['name' => 'sitedescription', 'value' => request('sitedescription')],
                ['name' => 'metakeyword', 'value' => request('metakeyword')],
            ];
            foreach ($arrayValues as $value) {
                Setting::where('name', $value['name'])->update(['value' => $value['value']]);
            }
            return response()->json(['success' => 'Saving successfully!']);
        }

        if (request()->has('web_contact')) {
            $arrayValues = [
                ['name' => 'street', 'value' => request('street')],
                ['name' => 'city', 'value' => request('city')],
                ['name' => 'postal_code', 'value' => request('postal_code')],
                ['name' => 'state', 'value' => request('state')],
                ['name' => 'country', 'value' => request('country')],
                ['name' => 'fulladdress', 'value' => request('fulladdress')],
                ['name' => 'sitephone', 'value' => request('sitephone')],
                ['name' => 'siteemail', 'value' => request('siteemail')],
                ['name' => 'contactdescription', 'value' => request('contactdescription')],
                ['name' => 'facebook', 'value' => request('facebook')],
                ['name' => 'twitter', 'value' => request('twitter')],
                ['name' => 'youtube', 'value' => request('youtube')],
                ['name' => 'instagram', 'value' => request('instagram')],
                ['name' => 'linkedin', 'value' => request('linkedin')],
                ['name' => 'telegram', 'value' => request('telegram')],
                ['name' => 'whatsapp', 'value' => request('whatsapp')],
            ];
            foreach ($arrayValues as $value) {
                Setting::where('name', $value['name'])->update(['value' => $value['value']]);
            }
            return response()->json(['success' => 'Saving successfully!']);
        }

        if (request()->has('site_logo')) {

            if (request()->hasFile('favicon')) {
                $getFileName = pathinfo(request()->favicon->getClientOriginalName(), PATHINFO_FILENAME);
                $getFileExtension = pathinfo(request()->favicon->getClientOriginalExtension(), PATHINFO_FILENAME);

                $fileName = $getFileName . '-' . Str::random(10) . '.' . $getFileExtension;

                if ($getFileExtension == 'ico') {
                    $upload_path = storage_path('app/public/assets');

                    $image = request('favicon');
                    $imageName = $fileName;
                    $image->move($upload_path, $imageName);
                    Image::configure(array('driver' => 'imagick'));
                    $img = Image::make($upload_path .'/'. $fileName)
                        ->resize(32, 32, function($constraint){
                            $constraint->aspectRatio();
                        })->save($upload_path .'/'. $imageName);

                } else {
                    $img = Image::make(request('favicon'));
                    $resizeImage = $img->resize(32, 32);
                    $img->insert($resizeImage, 'center');

                    if (!File::exists(storage_path('app/public/assets'))) {
                        File::makeDirectory(storage_path('app/public/assets'));
                    }

                    $img->save(storage_path('app/public/assets') . '/' . $fileName);
                }

                Setting::where('name', 'favicon')->update(['value' => $fileName]);
            }

            if (request()->hasFile('logowebsite')) {
                $filename = request()->logowebsite->getClientOriginalName();
                if (!File::exists(storage_path('app/public/assets'))) {
                    File::makeDirectory(storage_path('app/public/assets'));
                }
                request()->logowebsite->storeAs('assets', $filename, 'public');
                Setting::where('name', 'logowebsite')->update(['value' => $filename]);
            }

            if (request()->hasFile('logowebsite_footer')) {
                $filename = request()->logowebsite_footer->getClientOriginalName();
                if (!File::exists(storage_path('app/public/assets'))) {
                    File::makeDirectory(storage_path('app/public/assets'));
                }
                request()->logowebsite_footer->storeAs('assets', $filename, 'public');
                Setting::where('name', 'logowebsite_footer')->update(['value' => $filename]);
            }

            if (request()->hasFile('ogimage')) {
                $filename = request()->ogimage->getClientOriginalName();
                if (!File::exists(storage_path('app/public/assets'))) {
                    File::makeDirectory(storage_path('app/public/assets'));
                }
                request()->ogimage->storeAs('assets', $filename, 'public');
                Setting::where('name', 'ogimage')->update(['value' => $filename]);
            }

            if (request()->hasFile('logodashboard')) {

                $filename = request()->logodashboard->getClientOriginalName();
                if (!File::exists(storage_path('app/public/assets'))) {
                    File::makeDirectory(storage_path('app/public/assets'));
                }
                request()->logodashboard->storeAs('assets', $filename, 'public');
                Setting::where('name', 'logodashboard')->update(['value' => $filename]);
            }

            if (request()->hasFile('logoauth')) {
                $filename = request()->logoauth->getClientOriginalName();
                if (!File::exists(storage_path('app/public/assets'))) {
                    File::makeDirectory(storage_path('app/public/assets'));
                }
                request()->logoauth->storeAs('assets', $filename, 'public');
                Setting::where('name', 'logoauth')->update(['value' => $filename]);
            }

            return redirect()->route('settings.index')->withSuccess(__('Saving successfully!'));
        }

        if (request()->has('web_config')) {
            $arrayValues = [
                ['name' => 'googleanalyticsid', 'value' => request('googleanalyticsid')],
                ['name' => 'googlemapcode', 'value' => request('googlemapcode')],
                ['name' => 'publisherid', 'value' => request('publisherid')],
                ['name' => 'disqusshortname', 'value' => request('disqusshortname')],
                ['name' => 'disqusshortname', 'value' => request('disqusshortname')],
                ['name' => 'analytics_view_id', 'value' => request('analytics_view_id')],
            ];

            if (request()->hasFile('credentials_file')) {
                $filename = request()->credentials_file->getClientOriginalName();
                if (!File::exists(storage_path('app/analytics'))) {
                    File::makeDirectory(storage_path('app/analytics'));
                }
                request()->credentials_file->storeAs('', $filename, 'analytics');
                array_push($arrayValues, ['name' => 'credentials_file', 'value' => request('credentials_file')]);
            }

            $env = new DotenvEditor();
            if (!$env->keyExists("ANALYTICS_VIEW_ID")) {
                $env->addData([
                    'ANALYTICS_VIEW_ID' => request('analytics_view_id')
                ]);
            } else {
                $env->changeEnv([
                    'ANALYTICS_VIEW_ID' => request('analytics_view_id')
                ]);
            }

            foreach ($arrayValues as $value) {
                Setting::where('name', $value['name'])->update(['value' => $value['value']]);
            }

            return Redirect::to(URL::previous() . "#web-config")->withSuccess(__('Saving successfully!'));
        }

        if (request()->has('web_permalinks')) {
            if(request('permalink') == 'custom'){
                $permalink = request('custom_input');
                $permalink_type = request('permalink');
                $permalink_old_custom = request('custom_input');
            }else{
                $permalink = request('permalink');
                $permalink_type = request('permalink');
                $permalink_old_custom = Settings::get('permalink_old_custom');
            }
            $arrayValues = [
                ['name' => 'permalink_type', 'value' => $permalink_type ],
                ['name' => 'permalink', 'value' => $permalink],
                ['name' => 'permalink_old_custom', 'value' => $permalink_old_custom],
            ];
            foreach ($arrayValues as $value) {
                Setting::where('name', $value['name'])->update(['value' => $value['value']]);
            }
            return response()->json(['success' => __('Saving successfully!')]);
        }
    }

    /**
     * @param $filename
     * @return string
     */
    public function getLogo($filename)
    {
        $file = Storage::get('public/assets/' . $filename);
        $type = Storage::disk('public')->mimeType('assets/' . $filename);
        return 'data:'.$type.';base64,' .base64_encode($file);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.setting.index');
    }

    /**
     * @return Application|SessionManager|Store|mixed
     */
    public function sessionDeviceSetPeriode(){
        $day = (int)request('periode');
        return session(['session_device_analytics' => $day]);
    }

    /**
     * @return Application|SessionManager|Store|mixed
     */
    public function visitorPageViewSetPeriode(){
        $day = (int)request('periode');
        return session(['session_visitor_pageview_analytics' => $day]);
    }

    /**
     * @return Application|SessionManager|Store|mixed
     */
    public function mostVisitedPages(){
        $day = (int)request('periode');
        return session(['session_most_visited_pages' => $day]);
    }

    /**
     * @return Application|SessionManager|Store|mixed
     */
    public function browserUsed(){
        $day = (int)request('periode');
        return session(['session_browser_used' => $day]);
    }

    /**
     * @return Application|SessionManager|Store|mixed
     */
    public function operatingSystem(){
        $day = (int)request('periode');
        return session(['session_browser_used' => $day]);
    }

    /**
     * @return Application|SessionManager|Store|mixed
     */
    public function sessionsCountry(){
        $day = (int)request('periode');
        return session(['session_country' => $day]);
    }

    /**
     * @return mixed
     */
    public function sitemap()
    {
        $sitemap = Sitemap::create()
            ->add(SpatieUrl::create('/'))
            ->add(SpatieUrl::create('/contact'));

        Post::where('post_type', 'page')->each(function (Post $page) use ($sitemap) {
            $sitemap->add(SpatieUrl::create("/page/{$page->post_name}"));
        });

        Post::all()->each(function (Post $post) use ($sitemap) {

            if (Settings::get('permalink') == "%year%/%month%/%day%") {
                $year  = $post->created_at->format('Y');
                $month = $post->created_at->format('m');
                $day   = $post->created_at->format('d');
                $sitemap->add(SpatieUrl::create("/{$year}/{$month}/{$day}/{$post->post_name}"));
            } elseif (Settings::get('permalink') == "%year%/%month%") {
                $year  = $post->created_at->format('Y');
                $month = $post->created_at->format('m');
                $sitemap->add(SpatieUrl::create("/{$year}/{$month}/{$post->post_name}"));
            } else {
                $word = Settings::get('permalink') != 'post_name' ? Settings::get('permalink') : '';
                $sitemap->add(SpatieUrl::create("/{$word}/{$post->post_name}"));
            }
        });
        $sitemap->writeToFile(public_path('sitemap.xml'));

        return Redirect::to(URL::previous() . "#web-config")->withSuccess(__('Generate sitemap successfully!'));
    }

    /**
     * @return BinaryFileResponse
     */
    public function exportStorage(): BinaryFileResponse
    {
        $zip = new ZipArchive;

        $fileName = 'laramagz-storage.zip';

        if ($zip->open(storage_path($fileName), ZipArchive::CREATE) === TRUE)
        {
            if(Storage::disk('local')->exists('analytics')){
                $ads = File::files(storage_path('app/analytics'));
                foreach ($ads as $key => $value) {
                    $relativeNameInZipFile = 'analytics/'.basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }
            }

            if(Storage::disk('public')->exists('ad')){
                $ads = File::files(storage_path('app/public/ad'));
                foreach ($ads as $key => $value) {
                    $relativeNameInZipFile = 'public/ad/'.basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }
            }

            if(Storage::disk('public')->exists('assets')){
                $assets = File::files(storage_path('app/public/assets'));
                foreach ($assets as $key => $value) {
                    $relativeNameInZipFile = 'public/assets/'.basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }
            }

            if(Storage::disk('public')->exists('avatar')){
                $avatars = File::files(storage_path('app/public/avatar'));
                foreach ($avatars as $key => $value) {
                    $relativeNameInZipFile = 'public/avatar/'.basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }
            }

            if(Storage::disk('public')->exists('images')){
                $images = File::files(storage_path('app/public/images'));
                foreach ($images as $key => $value) {
                    $relativeNameInZipFile = 'public/images/'.basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }
            }

            if(Storage::disk('public')->exists('theme')){
                $themes = File::files(storage_path('app/public/theme'));
                foreach ($themes as $key => $value) {
                    $relativeNameInZipFile = 'public/theme/'.basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }
            }

            $zip->close();
        }

        return response()->download(storage_path($fileName))->deleteFileAfterSend(true);
    }

    /**
     * @return mixed
     */
    public function export()
    {
        return (new MagzExports())->download('laramagz-backup.xlsx');
    }

    /**
     * @return JsonResponse
     */
    public function import()
    {
        $validator = Validator::make(request()->all(), [
            'import' => 'required|mimes:xlsx'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Excel::import(new MagzImport, request()->file('import'));

        return response()->json(['success' => __('Import successfully')]);
    }
}

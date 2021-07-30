<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdvertisementDataTable;
use App\Helpers\Images;
use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\GoogleAdsense;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AdvertisementController extends Controller
{
    /**
     * AdvertisementController constructor.
     */
    public function __construct()
    {
        config(['file-manager.diskList' => 'ad']);
        if (!File::exists(storage_path('app/public/ad'))) {
            File::makeDirectory(storage_path('app/public/ad'));
        }
        $this->middleware('permission:read-ads');
        $this->middleware('permission:add-ads', ['only' => ['create']]);
        $this->middleware('permission:update-ads', ['only' => ['edit']]);
    }

    /**
     * @return mixed
     */
    public function ajaxSearch()
    {
        return Advertisement::select('id', 'name', 'size')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @param AdvertisementDataTable $dataTable
     * @return Response
     */
    public function index(AdvertisementDataTable $dataTable)
    {
        return $dataTable->render('admin.advertisement.index');
    }

    /**
     * @return JsonResponse
     */
    public function changeAdActive()
    {
        $ad         = Advertisement::find(request('id'));
        $ad->active = request('active');
        $ad->save();

        return response()->json(['success' => __('Status change successfully.')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.advertisement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name'   => 'required|unique:advertisements|regex:/^[\pL\-_\s]+\s?[\pL\-0-9]*$/i',
            'width'  => 'required_if:type,image',
            'height' => 'required_if:type,image',
            'image'  => 'mimes:jpeg,png,gif|file|max:1000|dimensions:max_width=1000,max_height=1000'
        ]);

        if ($validator->fails()) {
            return redirect('admin/manage/advertisement/create')
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'name'   => clean(Str::title(request('name'))),
            'type'   => request('type'),
            'active' => 'y'
        ];

        if (request('type') == 'image')
        {
            $upload_file = request()->file('image');
            $height      = Image::make($upload_file)->height();
            $width       = Image::make($upload_file)->width();

            $fileName = Images::fileName(request('image'));
            request()->image->storeAs('ad', $fileName, 'public');

            $data['url']   = request('url') ? request('url') : '#';
            $data['image'] = request()->hasFile('image') ? $fileName : null;
            $data['size']  = $width . 'x' . $height;
        } else if (request('type') == 'ga') {

            if(GoogleAdsense::where('ad_slot', request('ad_slot'))->exists()){
                return redirect()->route('advertisement.create')->withError(__('Ad Slot has already been taken!'));
            }

            $ga = new GoogleAdsense;
            $ga->ad_slot = clean(request('ad_slot'));
            $ga->ad_client = clean(request('ad_client'));
            $ga->ad_size = request('ad_size');

            if (request('ad_size') == "fixed") {
                $ga->ad_width = request('ad_width');
                $ga->ad_height = request('ad_height');
            } else {
                $ga->ad_format = request('ad_format');
                $ga->full_width_responsive = request('full_width_responsive');
            }

            $ga->save();

            $data['ga'] = request('ad_slot');
        } else if (request('type') == 'script_code') {
            Storage::disk('public')->put('ad/'.Str::slug(request('name')).'-script.blade.php', request('script_custom'));
        }

        Advertisement::create($data);

        return redirect()->route('advertisement.index')->withSuccess(__('Saving successfully!'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $ad = Advertisement::findOrFail($id);

        $image       = null;
        $width       = null;
        $height      = null;
        $script_code = null;
        $ga          = null;
        $url         = null;
        if ($ad->type == 'image') {
            if ($ad->image) {
                $exists = Storage::disk('public')->exists('ad/' . $ad->image);
                if ($exists) {
                    $file   = Storage::get('public/ad/' . $ad->image);
                    $type   = Storage::disk('public')->mimeType('ad/' . $ad->image);
                    $image  = 'data:' . $type . ';base64,' . base64_encode($file);
                    $size   = explode('x', $ad->size);
                    $width  = $size[0];
                    $height = $size[1];
                    $url    = $ad->url == '#' ? '' : $ad->url;
                }
            }
        } else if ($ad->type == 'ga') {
            $ga = GoogleAdsense::where('ad_slot', $ad->ga)->first();
        } else if ($ad->type == 'script_code') {
            $script_code = File::get(storage_path('app/public/ad/'.Str::slug($ad->name).'-script.blade.php'));
        }

        return view('admin.advertisement.edit', compact('ad','image','width','height','script_code','ga','url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required|unique:advertisements,name, ' . $id . ',id|regex:/^[\pL\-_\s]+\s?[\pL\-0-9]*$/i',
            'width'  => 'required_if:type,image',
            'height' => 'required_if:type,image',
            'image'  => 'mimes:jpeg,png,gif|file|max:1000|dimensions:max_width=1000,max_height=1000'
        ]);

        $ad = Advertisement::findOrFail($id);

        if (request('type') == 'image')
        {
            if ($ad->type == 'script_code') {
                $exists = Storage::disk('public')->exists('ad/' . Str::slug($ad->name) . '-script.blade.php');
                if ($exists) {
                    Storage::disk('public')->delete('ad/' . Str::slug($ad->name) . '-script.blade.php');
                }
            } else if ($ad->type == 'ga') {
                $exists = Storage::disk('public')->exists('ad/' . Str::slug($ad->name) . '-ga.blade.php');
                if ($exists) {
                    Storage::disk('public')->delete('ad/' . Str::slug($ad->name) . '-ga.blade.php');
                }
            }

            if (request('image')) {
                $exists = Storage::disk('public')->exists('ad/' . $ad->image);
                if ($exists) {
                    Storage::disk('public')->delete('ad/' . $ad->image);
                }
                $upload_file = request()->file('image');
                $height = Image::make($upload_file)->height();
                $width = Image::make($upload_file)->width();
                $fileName = Images::fileName(request('image'));
                request()->image->storeAs('ad', $fileName, 'public');

                $ad->size = $width . 'x' . $height;
                $ad->image = request()->hasFile('image') ? $fileName : null;
            }
            $ad->url = request('url') ? request('url') : '#';
        } else if (request('type') == 'ga') {
            if ($ad->ga) {
                $ga = GoogleAdsense::where(request('ad_slot'))->first();
                $ga->ad_size = clean(request('ad_size'));

                if (request('ad_size') == "fixed") {
                    $ga->ad_width  = request('ad_width');
                    $ga->ad_height = request('ad_height');
                } else {
                    $ga->ad_format             = clean(request('ad_format'));
                    $ga->full_width_responsive = clean(request('full_width_responsive'));
                }

                $ga->save();
            } else {
                $ga            = new GoogleAdsense;
                $ga->ad_slot   = clean(request('ad_slot'));
                $ga->ad_client = clean(request('ad_client'));
                $ga->ad_size   = clean(request('ad_size'));

                if (request('ad_size') == "fixed") {
                    $ga->ad_width  = request('ga_width');
                    $ga->ad_height = request('ga_height');
                } else {
                    $ga->ad_format             = clean(request('ad_format'));
                    $ga->full_width_responsive = clean(request('full_width_responsive'));
                }

                $ga->save();
                $ad->ga = clean(request('ad_slot'));
            }

            $ad->size = "";

        } else if (request('type') == 'script_code') {
            if ($ad->type == 'ga') {
                $exists = Storage::disk('public')->exists('ad/' . Str::slug($ad->name) . '-ga.blade.php');
                if ($exists) {
                    Storage::disk('public')->delete('ad/' . Str::slug($ad->name) . '-ga.blade.php');
                }
            } else if ($ad->type == 'image') {
                $exists = Storage::disk('public')->exists('ad/' . $ad->image);
                if ($exists) {
                    Storage::disk('public')->delete('ad/' . $ad->image);
                }
            }

            if (request('name') != $ad->name) {
                if($ad->type = 'script_code') {
                    Storage::disk('public')->delete('ad/' . Str::slug($ad->name).'-script.blade.php');
                }
                Storage::disk('public')->put('ad/'.Str::slug(request('name')).'-script.blade.php', request('script_custom'));
            } else {
                Storage::disk('public')->put('ad/'.Str::slug($ad->name).'-script.blade.php', request('script_custom'));
            }
        }

        $ad->name   = clean(Str::title(request('name')));
        $ad->type   = request('type');
        $ad->active = 'y';
        $ad->updated_at = Carbon::now();
        $ad->save();

        return redirect()->route('advertisement.index')
            ->withSuccess(__('Updating successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if (Gate::allows('delete-ads')) {
            $ad = Advertisement::findOrFail($id);
            if ($ad->type == 'image') {
                $exists = Storage::disk('public')->exists('ad/' . $ad->image);
                if ($exists) {
                    Storage::disk('public')->delete('ad/' . $ad->image);
                }
            } else if ($ad->type == 'ga') {
                if ($ad->type = 'script_code') {
                    Storage::disk('public')->delete('ad/' . Str::slug($ad->name) . '-script.blade.php');
                }
            } else if ($ad->type == 'script_code') {
                if ($ad->type = 'ga') {
                    Storage::disk('public')->delete('ad/' . Str::slug($ad->name) . '-ga.blade.php');
                }
            }
            Advertisement::destroy($id);
            return response()->json(['success' => __('Deleted successfully.')]);
        } else {
            return response()->json(['error' => __('Sorry, you don\'t have permission.')]);
        }
    }

    /**
     * Remove the multi resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function massdestroy(Request $request)
    {
        if (Gate::allows('delete-ads')) {
            $ads_id_array = $request->id;
            $ads = Advertisement::whereIn('id', $ads_id_array)->get();

            foreach($ads as $item) {
                if ($item->type == 'image') {
                    $exists = Storage::disk('public')->exists('ad/' . $item->image);
                    if ($exists) {
                        Storage::disk('public')->delete('ad/' . $item->image);
                    }
                } else if ($item->type== 'ga') {
                    $exists = Storage::disk('public')->exists('ad/' . Str::slug($item->name).'-ga.blade.php');
                    if ($exists) {
                        Storage::disk('public')->delete('ad/' . Str::slug($item->name) . '-ga.blade.php');
                    }
                } else if ($item->type == 'script_code') {
                    $exists = Storage::disk('public')->exists('ad/' . Str::slug($item->name).'-script.blade.php');
                    if ($exists) {
                        Storage::disk('public')->delete('ad/' . Str::slug($item->name) . '-script.blade.php');
                    }
                }
            }

            $ad = Advertisement::whereIn('id', $ads_id_array);

            if($ad->delete()) {
                return response()->json(['success' => __('Deleted successfully.')]);
            } else {
                return response()->json(['error' => __('Deleted not successfully.')]);
            }
        } else {
            return response()->json(['error' => __('Sorry, you don\'t have permission.')]);
        }
    }
}

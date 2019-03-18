<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Curl;
class LocationController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
//        $this->middleware('admin');
    }

    public function set_address_default(Request $request){
        $data = [
            'province_id'   => $request->input('province_id',''),
            'district_id'   => $request->input('district_id',''),
            'ward_id'       => $request->input('ward_id',''),
        ];

        if(empty($data['province_id']) || empty($data['district_id']))
            return redirect()->back();

        $data['full_address'] = \App\Helpers\General::getAddressByDistrict($data['district_id']);
        session([\App\Helpers\General::key_address_default() => $data]);
        return redirect()->back();
    }

    public function geoIdsByAddress(Request $request) {
        $address = $request->input('address', '');

        \App\Helpers\General::telegram_log('geoIdsByAddress: '.$address);

        $object = Province::select(['provinces.province_id', \DB::raw("CONCAT_WS(' ', provinces.type, provinces.name) as province_name"),
            'districts.district_id', \DB::raw("CONCAT_WS(' ', districts.type, districts.name) as district_name"),
            'wards.ward_id', \DB::raw("CONCAT_WS(' ', wards.type, wards.name) as ward_name")])
            ->leftJoin('districts', 'districts.province_id', '=', 'provinces.province_id')
            ->leftJoin('wards', 'wards.district_id', '=', 'districts.district_id')
            ->where(\DB::Raw("'".$address."'"), 'LIKE', \DB::Raw('CONCAT("%", provinces.name, "%")'))
            ->where(\DB::Raw("'".$address."'"), 'LIKE', \DB::Raw('CONCAT("%", districts.name, "%")'))
            ->where(\DB::Raw("'".$address."'"), 'LIKE', \DB::Raw('CONCAT("%", wards.name, "%")'))
            ->orderBy('wards.name', 'desc')
            ->orderBy('districts.name', 'desc')
            ->orderBy('provinces.name', 'desc')
            ->first();
//            ->toSql();

        if ($object) {
            $object = $object->toArray();
            $object['formatted_address'] = $address;
            $object['full_address'] = \App\Helpers\General::getAddressByDistrict($object['district_id'], $object);
            session([\App\Helpers\General::key_address_default() => $object]);

            \App\Helpers\General::telegram_log('geoIdsByAddress found: '.json_encode($object));

            return response()->json([
                'rs' => 1,
                'data' => $object
            ]);
        }

        return response()->json([
            'rs' => 0,
            'data' => $address,
            'msg' => 'Not geo ids address'
        ]);
    }

    public function index(Request $request) {
//        return view('location.index', $this->data);
    }

    public function get_provinces(Request $request)
    {
        $objects = \App\Models\Province::select('province_id', \DB::raw("CONCAT_WS(' ', provinces.type, provinces.name) as province_name"))
            ->where('provinces.is_deleted', 0);

        $has_asset = $request->input('has_asset', 0);
        if ($has_asset) {
            $objects->whereExists(function ($qs) {
                $qs->select(\DB::raw(1))
                    ->from('assets')
                    ->whereRaw('assets.province_id = provinces.province_id')
                    ->where('assets.is_deleted', 0);
            });
        }

        $objects = $objects->orderBy('ordering', 'asc')->pluck('province_name', 'province_id')->toArray();

        return response()->json([
            'rs' => 1,
            'data' => $objects
        ]);
    }

    public function get_districts(Request $request)
    {
        $province_id = $request->input('province_id', '');
        $has_asset = $request->input('has_asset', 0);
        $status = $request->input('status', '');

        $objects = \App\Models\District::select('district_id', \DB::raw("CONCAT_WS(' ', type, name) as district_name"))
            ->where('province_id', $province_id)
            ->where('is_deleted', 0);

        if ($has_asset) {
            $objects->whereExists(function ($qs) use ($status) {
                $qs->select(\DB::raw(1))
                    ->from('assets')
                    ->where('assets.is_deleted', 0)
                    ->whereRaw('assets.district_id = districts.district_id');

                if ($status) {
                    $qs->where('assets.status', $status);
                }
            });
        }

        $objects = $objects->pluck('district_name', 'district_id');

        return response()->json([
            'rs' => 1,
            'data' => $objects
        ]);
    }

    public function get_wards(Request $request)
    {
        $district_id = $request->input('district_id', '');
        $has_asset = $request->input('has_asset', 0);

        $objects = \App\Models\Ward::select('ward_id', \DB::raw("CONCAT_WS(' ', type, name) as ward_name"))
            ->where('district_id', $district_id)
            ->where('is_deleted', 0);

        if ($has_asset) {
            $objects->whereExists(function ($qs) {
                $qs->select(\DB::raw(1))
                    ->from('assets')
                    ->where('assets.is_deleted', 0)
                    ->whereRaw('assets.ward_id = wards.ward_id');
            });
        }

        $objects = $objects->pluck('ward_name', 'ward_id');

        return response()->json([
            'rs' => 1,
            'data' => $objects
        ]);
    }

    public function show(Request $request,$slug,$id){
//        return view('location.show', $this->data);
    }

    public function getDirection($origin,$destination,$mode){
        $key            = env('GOOGLE_MAP_API_KEY','AIzaSyAtvMzWza6t7gtEIAZmuuVNBqleCrZEfOU');
        $api_directions = env('GOOGLE_MAP_API_DIRECTION','https://maps.googleapis.com/maps/api/directions/json');

        $params = [
            'origin'        => $origin,
            'destination'   => $destination,
            'mode'          => $mode,
            'key'           => $key,
            'language'      => 'vi'
        ];
       
        $request_api = Curl::to($api_directions)
            ->withResponseHeaders()
            ->withData($params)
            ->returnResponseObject();
        $response = $request_api->get();

        $content = json_decode($response->content, 1);

        return $content;
        
    }
}

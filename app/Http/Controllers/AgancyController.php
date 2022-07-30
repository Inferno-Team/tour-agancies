<?php

namespace App\Http\Controllers;

use App\Models\Agancy;
use App\Models\City;
use App\Models\Place;
use App\Models\PlaceTimeModel;
use App\Models\TimeStep;
use App\Models\TourDetails;
use App\Models\TourTimePlaceModel;
use App\Models\TourUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Ui\Presets\React;

class AgancyController extends Controller
{

    protected function convertBase64ToFile(String $base64)
    {
        $image_64 = $base64; //your base64 encoded data

        $extension = explode(
            '/',
            explode(':', substr($image_64, 0, strpos($image_64, ';')))[1]
        )[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

        // find substring fro replace here eg: data:image/png;base64,

        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);
        return [base64_decode($image), $extension];
    }
    public function createAgancy(Request $request)
    {
        $user = Auth::user();
        info($request);
        if ($user->user_type == 'manager') {
            $checkAgancy = Agancy::where('manager_id', $user->id)->first();
            if (isset($checkAgancy))
                return response()->json([
                    'code' => 300,
                    'message' => "you can't create more then one agancy"
                ], 200);
            $agancy = Agancy::create([
                'name' => $request->name,
                'location' => $request->location,
                'city_id' => $request->city_id,
                'manager_id' => $user->id,
                'img_url' => ''
            ]);
            info($request->all());
            if (isset($request->logo)) {
                $image = $this->convertBase64ToFile($request->logo);
                $timeNow = time() ;
                $imageName = '/images/logos/' . $timeNow . '.' . $image[1];
                Storage::disk('public')->put($imageName, $image[0]);
                $agancy->img_url = "storage$imageName";
                $agancy->save();
            }
            return response()->json([
                'message' => "Agancy created successfully",
                'code' => 200,
                'agancy' => $agancy
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }

    public function addPlace(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'manager') {
            $place = Place::create([
                'name' => $request->name,
                'address' => $request->address,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'disc' => $request->disc,
                'img_url' => '',
            ]);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $ext = $image->getClientOriginalExtension();
                $name = time() . ".$ext";
                $path = '/public/images/places';
                $image->storeAs($path, $name);
                $place->img_url = "/storage/images/places/$name";
                $place->save();
            }
            return response()->json([
                'code' => 200,
                'message' => 'created successfully',
                'data' => $place
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route",
                'code' => 403,
            ], 200);
        }
    }
    public function addTime(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'manager') {
            $timeStep = TimeStep::create([
                'start' => $request->start,
                'end' => $request->end,
            ]);
            return response()->json([
                'code' => 200,
                'message' => 'created successfully',
                'data' => $timeStep
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }

    public function createTour(Request $request)
    {
        $user = Auth::user();
        // $startDate = date('Y-m-d H:i:s', $request->start_at / 1000);
        // $endDate = date('Y-m-d H:i:s', $request->end_at / 1000);
        $startDate = $request->start_at;
        $endDate = $request->end_at;

        if ($user->user_type == 'manager') {
            $checkAgancy = Agancy::where('manager_id', $user->id)->first();
            $city = City::where("name", $request->cityName)->first();
            if (!isset($checkAgancy))
                return response()->json([
                    'code' => 300,
                    'message' => "you don't have an agancy yet."
                ], 200);

            $tour = TourDetails::create([
                'agancy_id' => $checkAgancy->id,
                'city_id' => $city->id,
                'cost' => $request->cost,
                'seat_count' => $request->seat_count,
                'start_at' => $startDate,
                'end_at' => $endDate,
            ]);
            return response()->json([
                "code" => 200,
                'message' => "created successfully",
                'data' => $tour
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }
    public function addTourPlaceWithImage(Request $request)
    {
        info($request);
        $place = Place::create(
            [
                'name' => $request->name,
                'address' => $request->location,
                'lat' => $request->latitude,
                'lng' => $request->longitude,
                'disc' => $request->disc,
                'img_url' => ''

            ]
        );

        if ($request->hasFile('place_image')) {
            $image = $request->file('place_image');
            $ext = $image->getClientOriginalExtension();
            $path = 'public/images/places';
            $timeNow = time();
            $name = $timeNow . $ext;
            $image->storeAs($path, $name);
            $place->img_url = "storage/images/places/$name";
            $place->save();
        }
        return response()->json([
            'code' => 200,
            'msg' => 'place added succesffully',
            'place' => $place
        ], 200);
    }
    public function addPlace2Tour(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'manager') {
            $tourPlaceTime = TourTimePlaceModel::create([
                'tour_id' => $request->tour_id,
                'place_id' => $request->place_id,
                'time_id' => $request->time_id,
                'day' => $request->day,
            ]);
            return response()->json([
                "code" => 200,
                'message' => "created successfully",
                'data' => $tourPlaceTime
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }
    public function getAgancy()
    {
        $user = Auth::user();
        if ($user->user_type == 'manager') {
            $checkAgancy = Agancy::where('manager_id', $user->id)->first();
            if (!isset($checkAgancy))
                return response()->json([
                    'code' => 300,
                    'messge' => "you don't have an agancy"
                ], 200);
            return response()->json([
                'code' => 200,
                'messge' => "your agancy",
                'data' => $checkAgancy
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }
    public function getAllCities()
    {
        $user = Auth::user();
        if ($user->user_type == 'manager') {
            $cities = City::all();
            return response()->json($cities, 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }
    public function getTimes()
    {
        $user = Auth::user();
        if ($user->user_type == 'manager') {

            return response()->json([
                'code' => 200,
                'messge' => "time steps",
                'data' => TimeStep::get()
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }
    public function getPlaces()
    {
        $user = Auth::user();
        if ($user->user_type == 'manager') {

            return response()->json([
                'code' => 200,
                'messge' => "places",
                'data' => Place::get()
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }
    public function getMyAgancyTours()
    {
        $user = Auth::user();
        if ($user->user_type == 'manager') {
            $checkAgancy = Agancy::where('manager_id', $user->id)->first();
            if (!isset($checkAgancy))
                return response()->json([
                    'code' => 300,
                    'messge' => "you don't have an agancy"
                ], 200);
            return response()->json([
                'code' => 200,
                'messge' => "your agancy's tours",
                'data' => TourDetails::where('agancy_id', $checkAgancy->id)->get()
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }
    public function getTourSchedule(Request $request)
    {
        $tour = TourDetails::where('tour_details.id', $request->id)->with(
            'tourPlaceTime.timeStep',
            'tourPlaceTime.place',
            'agancy',
            // 'times',
            // 'places',
            'city'
        )->first();
        return response()->json([
            'code' => 200,
            'message' => "tour's schedule",
            'data' => $tour
        ], 200);
    }

    public function getPlaceById($id)
    {
        $place = Place::find($id);
        return response()->json($place);
    }
    public function bookOnTour(Request $request, int $id)
    {
        $user = Auth::user();
        if ($user->user_type == 'user') {
            $tour = TourDetails::find($id);
            if (!isset($tour)) {
                return response()->json([
                    'code' => 300,
                    'messge' => '',
                    'data' => "tour not found"
                ], 200);
            }
            $now = Carbon::now();
            if ($tour->end_at < $now) {
                return response()->json([
                    'code' => 300,
                    'messge' => '',
                    'data' => "tour is ended"
                ], 200);
            }
            $tourUsers = TourUser::where('tour_id', $tour->id)->get();
            $seatCount = count($tourUsers);
            if ($seatCount >= $tour->seat_count) {
                return response()->json([
                    'code' => 300,
                    'messge' => '',
                    'data' => "tour is full"
                ], 200);
            }
            $tourUser = TourUser::create(
                [
                    'user_id' => $user->id,
                    'tour_id' => $id,
                    'seat_number' => $seatCount + 1,
                    'payment_code' => $request->payment_code,
                    'payment_method' => $request->payment_method,
                ]
            );
            return response()->json([
                'code' => 200,
                'messge' => 'booked successfully',
                'data' => $tourUser
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }
    public function getToursByIds(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'user') {
            $tours = TourDetails::with('agancy')->whereIn('id', $request->ids)->get();
            return response()->json([
                'code' => 200,
                'messge' => 'all tours',
                'data' => $tours
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }

    public function cancelTour(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'user') {
            $tourUser = TourUser::where('tour_id', $request->tour_id)->first();
            if (!isset($tourUser)) {
                return response()->json([
                    'code' => 300,
                    'messge' => '',
                    'data' => false
                ], 200);
            }
            $tourUser->delete();
            return response()->json([
                'code' => 200,
                'messge' => 'canceled successfully',
                'data' => true
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }
    public function getIdsApproved(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'user') {
            info($request->ids);
            $ids = TourUser::whereIn('tour_id', $request->ids)->get()->map->format();
            info($ids);
            return response()->json([
                'code' => 200,
                'messge' => 'all tours',
                'data' => $ids
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route"
            ], 403);
        }
    }
    public function getAgancyTours(Request $request)
    {
        $user = Auth::user();
        $checkAgancy = Agancy::where('manager_id', $user->id)->first();
        if (!isset($checkAgancy))
            return response()->json([
                'code' => 300,
                'messge' => "there is no agancy with is id",
                'data' => []
            ], 200);
        return response()->json([
            'code' => 200,
            'messge' => "agancy's tours",
            'data' => TourDetails::where('agancy_id', $checkAgancy->id)
                ->orderBy('created_at', 'DESC')->with('city')->get()
        ], 200);
    }
    public function getAllRequests(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'manager') {
            $myAgency = Agancy::where('manager_id', $user->id)->first();
            $requests = TourUser::whereHas('tour', function ($query) use ($myAgency) {
                $query->where('agancy_id', $myAgency->id);
            })->get()->map->format();
            info($requests);
            return response()->json([
                'code' => 200,
                'messge' => 'all requests',
                'data' => $requests
            ], 200);
        }
    }
    public function approveRequest(Request $request)
    {
        $r = TourUser::where('id', $request->id)->first();
        $r->approved = $request->approved;
        $r->save();
        return response()->json([
            'response' => $r->approved,
            'code' => 200
        ], 200);
    }
    public function getAllPlaces()
    {
        $places = Place::all();
        return response()->json([
            'places' => $places,
            'code' => 200
        ], 200);
    }
    public function getAllTimes()
    {
        $times = TimeStep::all();
        return response()->json([
            'times' => $times,
            'code' => 200
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Agancy;
use App\Models\Place;
use App\Models\PlaceTimeModel;
use App\Models\TimeStep;
use App\Models\TourDetails;
use App\Models\TourTimePlaceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgancyController extends Controller
{
    public function createAgancy(Request $request)
    {
        $user = Auth::user();
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
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $ext = $image->getClientOriginalExtension();
                $name = time() . ".$ext";
                $path = '/public/images/logos';
                $image->storeAs($path, $name);
                $agancy->img_url = "/storage/images/logos/$name";
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
            if (!isset($checkAgancy))
                return response()->json([
                    'code' => 300,
                    'message' => "you don't have an agancy yet."
                ], 200);

            $tour = TourDetails::create([
                'agancy_id' => $checkAgancy->id,
                'city_id' => $request->city_id,
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
}

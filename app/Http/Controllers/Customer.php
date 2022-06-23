<?php

namespace App\Http\Controllers;

use App\Models\Agancy;
use App\Models\TourDetails;
use App\Models\TourUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customer extends Controller
{
    public function requestTour(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'user') {
            $tour = TourDetails::where('id', $request->id)->fierst();
            if (!isset($tour)) {
                return response()->json([
                    'message' => "The provided id of tour is unVaild ."
                ], 200);
            }
            $tu = TourUser::where('tour_id', $tour->id)
                ->where('seat_number', $request->seat_number)
                ->first();
            if (isset($tu)) {
                return response()->json([
                    'message' => "this requested seat on this tour is alredy taken"
                ], 200);
            }
            $userTour = TourUser::create([
                'user_id' => $user->id,
                'tour_id' => $tour->id,
                'payment_code' => $request->payment_code,
                'payment_method' => $request->payment_method,
                'seat_number' => $request->seat_number,
            ]);
            if (isset($userTour)) {
                return response()->json([
                    'message' => "request added successfully and waiting
                     for tour manager to approve it's may take 24 hours to 48 hours",
                    'code' => 200
                ], 200);
            } else {
                return response()->json([
                    'message' => "something wrong happend please try again later",
                    'code' => 300
                ], 200);
            }
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route",
                'code' => 403
            ], 200);
        }
    }
    public function getAgancy(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'user') {
            $checkAgancy = Agancy::where('id', $request->agancy_id)->first();
            if (!isset($checkAgancy))
                return response()->json([
                    'code' => 300,
                    'messge' => "there is no agancy with is id"
                ], 200);
            return response()->json([
                'code' => 200,
                'messge' => "agancy",
                'data' => $checkAgancy
            ], 200);
        } else {
            return response()->json([
                'message' => "you don't have permission to get access to this route",
                'code' => 403
            ], 200);
        }
    }
    public function getAllAgancy()
    {
        $user = Auth::user();
        if ($user->user_type == 'user') {
            $checkAgancy = Agancy::get();
            if (!isset($checkAgancy))
                return response()->json([
                    'code' => 300,
                    'messge' => "there is no agancies"
                ], 200);
            return response()->json([
                'code' => 200,
                'messge' => "agancy",
                'data' => $checkAgancy
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
        $checkAgancy = Agancy::where('manager_id', $request->agency_id)->first();
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

    public function getToures()
    {
        $user = Auth::user();
        if ($user->user_type == 'user') {
            $tours  = TourDetails::with('city')->orderBy('created_at')->simplePaginate(15);
           $items  = $tours->getCollection()->map->format();
            $tours->setCollection($items);
            return response()->json([
                'code' => 200,
                'messge' => "agancy's tours",
                'data' => $tours
            ], 200);
        } else {
            
            return response()->json([
                'message' => "you don't have permission to get access to this route",
                'code' => 403,
                'data' => []
            ], 200);
        }
    }
}

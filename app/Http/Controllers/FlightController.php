<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlightRequest;
use App\Http\Resources\AirportResource;
use App\Http\Resources\FlightResource;
use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function searchAirports()
    {
        $query = $_GET['query'] ?? '';

        $airports = Airport::query()->where('city', 'LIKE', "$query%")->orWhere('country', 'LIKE', "$query%")->get();
        return response()->json([
            'data' => [
                'items' => AirportResource::collection($airports)
            ]
        ], 200);
    }

    public function searchFlights(FlightRequest $request)
    {
        $flights = Flight::query()
            ->where('from_id', $request->from)
            ->where('to_id', $request->to)
            ->whereDate('from_date', $request->date1)
            ->whereDate('to_date', $request->date2)
            ->get();
        return response()->json([
            'data' => [
                'items' => FlightResource::collection($flights)
            ]
        ], 200);
    }
}

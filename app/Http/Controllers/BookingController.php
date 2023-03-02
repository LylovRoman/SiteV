<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\FlightResource;
use App\Http\Resources\PassengerResource;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function create(BookingRequest $request)
    {
        $flightFrom = Flight::query()->find($request->from_id);
        $flightBack = Flight::query()->find($request->back_id);
        $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($code), 0, 5);
        $booking = Booking::query()->create([
            'flight_from' => $request->from_id,
            'flight_back' => $request->back_id,
            'date_from' => $flightFrom->from_date,
            'date_back' => $flightBack->from_date,
            'code' => $code
        ]);
        foreach ($request->tourists as $tourist) {
            Passenger::query()->create([
                'booking_id' => $booking->id,
                'first_name' => $tourist['first_name'],
                'last_name' => $tourist['last_name'],
                'birth_date' => $tourist['birth_date'],
                'document_number' => $tourist['document_number']
            ]);
        }
        return response()->json([
            'data' => [
                'booking_id' => $code
            ]
        ],201);
    }

    public function check(Request $request, $code)
    {
        $booking = Booking::query()->find($code);
        $tourists = Passenger::query()->where('booking_id', $code)->get();
        $flight = Flight::query()->find($booking->flight_from);
        $response = array_merge(
            FlightResource::make($flight)->toArray($request),
            [
                'tourists' => PassengerResource::collection($tourists),
                'cost' => $flight->cost * $tourists->count()
            ],
        );
        return response()->json([
            'data' => $response
        ], 200);
    }

    public function checkMy(Request $request)
    {
        $passengers = Passenger::query()->where('document_number', Auth::user()->document_number)->get();
        foreach ($passengers as $passenger) {
            $booking = Booking::query()->find($passenger->booking_id);
            $tourists = Passenger::query()->where('booking_id', $passenger->booking_id)->get();
            $flight = Flight::query()->find($booking->flight_from);
            $response = array_merge(
                FlightResource::make($flight)->toArray($request),
                [
                    'tourists' => PassengerResource::collection($tourists),
                    'cost' => $flight->cost * $tourists->count()
                ],
            );
            $maxresponse[] = $response;
        }
        return response()->json([
            'data' => $maxresponse
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\Guest;
use Auth;
class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function bookingFinder($date)
    {
        $data=Booking::where('date', $date)
        ->get();

        return $data;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin_id=Auth::user()->id;
        $input=$request->all();
        $guest=Guest::create([
            'admin_id' => $admin_id,
            'name' => $input['name'],
            'mail' => $input['mail'],
            'phone' => $input['phone'],
            'nid' => $input['nid'],
            'address' => $input['address'],
            'gender' => $input['gender'],
            'dob' => $input['dob'],
        ]);
        foreach ($input['room'] as $key => $value)
        {
            $booking=Booking::create(
                [
                    'admin_id' => $admin_id,
                    'guest_id' => $guest->id,
                    'room' => $value['id'],
                    'bill' => $value['rent'],
                    'remarks' => $input['remarks'],
                    'date' => $input['date'],
                ]
            );

        }

        return response()->json([
            'msg' => 'Inserted',
            'status' => $guest
            ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}

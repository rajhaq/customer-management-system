<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Guest;
use Auth;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Guest::orderBy('name', 'asc')
        ->with('admin')
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
        // create guest
        $created=Guest::create([
            'admin_id' => $admin_id,
            'name' => $input['name'],
            'mail' => $input['mail'],
            'phone' => $input['phone'],
            'nid' => $input['nid'],
            'address' => $input['address'],
            'gender' => $input['gender'],
            'dob' => $input['dob'],
        ]);
        return response()->json([
                'msg' => 'Inserted',
                'status' => $created
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
        $admin_id=Auth::user()->id;
        $input=$request->all();
        $update=Guest::where('id',$id)->update(
            [
                'admin_id' => $admin_id,
                'name' => $input['name'],
                'mail' => $input['mail'],
                'phone' => $input['phone'],
                'nid' => $input['nid'],
                'address' => $input['address'],
                'gender' => $input['gender'],
                'dob' => $input['dob'],
            ]
        );
        return response()->json([
            'msg'=>'success',
            'status'=>$update
            ]);
    }
    public function guestUpdate(Request $request)
    {
        return Guest::where('id',$request->id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Guest::where('id','=',$id)
          ->first();
          if($destroy->count()){
            $destroy->delete();
            return response()->json(['msg'=>'success','status'=>$id]);
          } else {
            return response()->json(['msg'=>'error','status'=>$id]);
          }
    }
}

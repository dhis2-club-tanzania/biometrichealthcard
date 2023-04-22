<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Authentication;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    // Receive data about authentication of user
    public function ManageAuthentication(Request $request)
    {
        $request_flag = $request->input('request_flag');
        $fingerprint_device_id = $request->input('fingerprint_device_id');

        // Check if patient is recognized
        $recognized_finger_print = DB::table('patients')
                                        ->where('fingerprint_no', $fingerprint_device_id)
                                        ->get();

        if (!$recognized_finger_print) {
            return response()->json(['code'=> 400, 'message'=>'Un-registered person']);
        }

        // Setting attending time
        $setting_attending_time = Authentication::all();
        $attending_time = $setting_attending_time[0]->attending_in;

        // check if user is already marked IN and wants to be IN again
        if ($request_flag == "IN")
            $existing_attendance = DB::table('authentications')
                                        ->where('authentication_fingerprint_user', $recognized_finger_print[0]->name)
                                        ->where('authentication_status', true)
                                        ->get();

            if ($existing_attendance->exists()){
                return response('', 204);
            }
            // create attendance record
            else{
                $new_attendance = DB::table('authentications')
                                    ->updateOrCreate(['authentication_fingerprint_no', $recognized_finger_print[0]->fingerprint_no], ['authentication_status', true]);
            }



    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Authentication  $authentication
     * @return \Illuminate\Http\Response
     */
    public function show(Authentication $authentication)
    {
        // return view('authentication.show',['authentication' => $authentication] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Authentication  $authentication
     * @return \Illuminate\Http\Response
     */
    public function edit(Authentication $authentication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Authentication  $authentication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Authentication $authentication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Authentication  $authentication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Authentication $authentication)
    {
        //
    }
}

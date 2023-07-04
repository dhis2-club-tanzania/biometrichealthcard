<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use App\Models\Patient;
use App\Models\NhifMember;
use App\Models\Fingerprint;
use Illuminate\Http\Request;
use App\Models\Authentication;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AuthenticationController extends Controller
{
    // Receive data about authentication of user
    public function ManageAuthentication(Request $request)
    {
        $fingerprint_device_id = $request->input('fingerprint_no');
        $request_flag = $request->input('request_flag');

        // Check if patient is recognized
        $recognized_finger_print = Fingerprint::where('fingerprint_no', $fingerprint_device_id)->first();

        if($recognized_finger_print){
            // check if user is already marked IN and wants to be IN again
            if ($request_flag == "IN"){
                if (Authentication::where('fingerprint_id', $recognized_finger_print->fingerprint_no)
                                    ->where('authentication_status', true)
                                    ->exists())
                {
                    return response()->json(['code'=> 204, 'message'=>'Existing record']);
                }
                // create authentication record
                else{
                    $nhifdata = NhifMember::find($recognized_finger_print->nhif_member_id);

                    Log::info($recognized_finger_print->fingerprint_no);
                    $new_attendance = new Authentication();
                    $new_attendance->authentication_fingerprint_user = $nhifdata->FirstName . ' ' . $nhifdata->Surname;
                    $new_attendance->fingerprint_id = $recognized_finger_print->fingerprint_no;
                    $new_attendance->authentication_status = true;
                    $new_attendance->save();

                    return response()->json(['code'=> 200, 'message'=>'Request Succesful']);

                    return redirect(route('authentications.index'))->with('message', 'Auth detail added successfully!');
                }
            }

            if ($request_flag == "OUT"){
                Authentication::where('fingerprint_id', $recognized_finger_print->fingerprint_no)
                                    ->where('authentication_status', true)
                                    ->delete();

                return response()->json(['code'=> 200, 'message'=>'Patient Out']);

                return redirect(route('authentications.index'))->with('message', 'Patient Out!');
            }

        }

        else {
            return response()->json(['code'=> 400, 'message'=>'Un-registered person']);
        }
    }

    //start visit in icare
    public function startvisit()
    {
        $client = new Client();

        $response = $client->post('https://icare.dhis2.udsm.ac.tz/openmrs/ws/rest/v1/visit', [
            'form_params' => [
                'param1' => 'value1',
                'param2' => 'value2',
            ]
        ]);
    }

    //start visit in icare
    public function startvisitpage($authenticated_id)
    {
         // Retrieve the authenticated member records from the nhifmember table
         $authenticated = Authentication::findOrFail($authenticated_id);
         Log::info($authenticated_id);

        $authenticatedmember = $authenticated->fingerprint->nhif_member;

        Log::info($authenticatedmember);

        //fetchvisittypes
        $client = new Client([
            RequestOptions::VERIFY => false,
        ]);
        $response = $client->get('https://icare-student.dhis2.udsm.ac.tz/openmrs/ws/rest/v1/visittype', [
            'auth' => [
                'admin', 'Admin123'
            ]
            ]);
            if ($response->getStatusCode() === 200) {
                $visitTypes = json_decode($response->getBody(), true);

            }


        // check  active status
        if ($authenticatedmember->card_status === 'active') {
            return view('authentication.startvisit', compact('visitTypes'));
        }
        else if($authenticatedmember->card_status === 'not active') {
            return back()->with('error', 'NHIF member card is not active');
        }
        else{
            return back()->with('error', 'NHIF member does not exist');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('authentication.index', ['authentications' => Authentication::latest()->paginate(5)]);
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
        $authentication->delete();

        return redirect(route('authentications.index'))->with('message', 'Auth detail deleted successfully!');
    }
}

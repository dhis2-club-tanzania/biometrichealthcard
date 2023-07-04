<?php

namespace App\Http\Controllers;

use App\Models\NhifMember;
use App\Models\Fingerprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FingerprintController extends Controller
{
    /**
     * Display a listing of fingerprints.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Fingerprint $fingerprint)
    {
        // Log::info($fingerprint->nhifmember->id);
        return view('fingerprint.index', ['fingerprints' => Fingerprint::latest()->paginate(5)]);
    }

    /**
     * Show the form for creating a new fingerprint.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(NhifMember $nhifMember)
    {
        $unregisteredExists = Fingerprint::where('fingerprint_status', 'unregistered')->exists();

        if (!$unregisteredExists){
            return view('fingerprint.create', compact('nhifMember'));
        } else{
            return back()->with('error', 'Cannot register a new fingerprint now!');
        }
    }

    /**
     * Store a newly created fingerprint in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //function to save the member and fingerprint id generated to database
    public function store(Request $request)
    {
        //receiving and validating the member id and fingerprint no
        $validator = Validator::make($request->all(), [
            'nhif_member_id' => 'required|integer|max:255',
            'fingerprint_no' => 'required|integer|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $data = $validator->validated();
        $data['fingerprint_status'] = "UNREGISTERED";

        //saving to database
        Fingerprint::create($data);

        return redirect(route('fingerprints.index'))->with('message', 'fingerprint created successfully!');

    }

    //api function to send fingerprint number and member id to the device for fing. registration
    public function RegisterFingerprintPattern()
    {
        $data = DB::table('fingerprints')
                    ->whereNotNull('fingerprint_no')
                    ->where('fingerprint_status', "UNREGISTERED")
                    ->get();
        $fingerprint = $data[0];

        return response()->json(['patient_id' => $fingerprint->nhif_member_id, 'fingerprint_no' => $fingerprint->fingerprint_no, 'code' => 200 ]);

        return redirect(route('fingerprints.index'))->with('message', 'fingerprint sent to the device successfully!');

    }

    public function savefingerprint(Request $request)
    {
        Log::info($request->input('patient_id'));
        Log::info($request->input('fingerprint_no'));
        Log::info($request);

        $fingerprint = Fingerprint::where('fingerprint_no', $request->input('fingerprint_no'))
                                    ->where('nhif_member_id',$request->input('patient_id') )
                                    ->exists();

        Log::info($fingerprint);

        if(Fingerprint::where('fingerprint_no', $request->input('fingerprint_no'))
                        ->where('nhif_member_id',$request->input('patient_id') )
                        ->where('fingerprint_status','REGISTERED' )
                        ->exists())
        {

        return response()->json(['code' => 204, 'message'=>'Fingerprint Already Registered']);

        }

        else if ($fingerprint) {
            $validator = Validator::make($request->all(), [
                'fingerprint_no' => 'required|numeric',
                'patient_id' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['code'=> 204, 'VALIDATION_ERROR'=>$validator->errors()]);
            }

            // Get the valid data sent by the IoT device
            $data = $validator->validated();


            //update status to registered
            Fingerprint::where('nhif_member_id', $data['patient_id'])
                    ->where('fingerprint_no' , $data['fingerprint_no'])
                    ->update([
                        'fingerprint_status' => "REGISTERED",
                    ]);

            NhifMember::where('id', $data['patient_id'])
                    ->update([
                        'FingerprintStatus' => true,
                    ]);

            return response()->json(['code' => 200, 'message'=>'Request sent successfully']);
        }

        else {
            // Fingerprint ID does not exist, handle the error
            // Show an error message
            return response()->json(['code' => 400, 'message'=>'Fingerprint ID does not exist for registration']);
        }
    }

    public function report(){
        // Get the number of new fingerprints registered each week
        $fingerprintsByWeek = Fingerprint::selectRaw('YEARWEEK(created_at) as week, COUNT(*) as count')
                                        ->groupBy('week')
                                        ->orderBy('week', 'ASC')
                                        ->get();

        $fingerprint = Fingerprint::where('fingerprint_status', 'REGISTERED')->get();
        $fingerprintcount = Fingerprint::where('fingerprint_status', 'REGISTERED')->count();

        return view('fingerprint.report', ['fingerprintsByWeek' => $fingerprintsByWeek , 'fingerprints' => $fingerprint, 'fingerprintcount' => $fingerprintcount]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fingerprint  $fingerprint
     * @return \Illuminate\Http\Response
     */
    public function show(Fingerprint $fingerprint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fingerprint  $fingerprint
     * @return \Illuminate\Http\Response
     */
    public function edit(Fingerprint $fingerprint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fingerprint  $fingerprint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fingerprint $fingerprint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fingerprint  $fingerprint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fingerprint $fingerprint)
    {
        $nhifMember = $fingerprint->nhif_member;

        // Update the member's status to false
        $nhifMember->update(['FingerprintStatus' => false]);

        // delete the record
        $fingerprint->delete();

        return redirect(route('fingerprints.index'))->with('message', 'Fingerprint deleted successfully!');
    }
}

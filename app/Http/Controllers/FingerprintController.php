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
        return view('fingerprint.create', compact('nhifMember'));
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
        $validated = $request->validate([
            'nhif_member_id' => ['required', 'integer', 'max:255'],
            'fingerprint_no' => ['required', 'integer', 'max:255'],
        ]);

        $validated['fingerprint_status'] = "UNREGISTERED";

        //saving to database
        Fingerprint::create($validated);

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

        return response()->json(['patient_id' => $fingerprint->member_id, 'fingerprint_no' => $fingerprint->fingerprint_no, 'code' => 200 ]);

    }

    public function savefingerprint(Request $request)
    {
        Log::info($request->input('patient_id'));
        Log::info($request->input('fingerprint_no'));
        Log::info($request);

        $validator = Validator::make($request->all(), [
            'fingerprint_no' => 'required|numeric',
            'patient_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response('VALIDATION_ERROR', $validator->errors());
        }

        // Get the valid data sent by the IoT device
        $data = $validator->validated();

        Fingerprint::where('nhif_member_id', $data['patient_id'])
                ->where('fingerprint_no' , $data['fingerprint_no'])
                ->update([
                    'fingerprint_status' => "REGISTERED",
                ]);

        NhifMember::where('id', $data['patient_id'])
                ->update([
                    'FingerprintStatus' => true,
                ]);


        // Patient::where('id',$request->input('patient_id'))
        //             ->where('fingerprint_no' , $request->input('fingerprint_no'))
        //             ->update([
        //                 'status' => 'TRUE',
        //             ]);

        // Return a success response
        return response()->json(['code' => 200, 'message'=>'Request sent successfully']);
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
    public function destroy(Fingerprint $fingerprint, NhifMember $nhifMember)
    {
        $fingerprint->delete();

        $nhifMember->fingerprint_status = false;

        return redirect(route('fingerprints.index'))->with('message', 'Fingerprint deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use console;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    // searching for a patient so as register their fingerprint
    public function search(Request $request)
    {
        //receiving patient data from the input field on the modal
        $query = $request->input('query');

        //searching for the data in the patients database
        $patientlist = DB::table('patients')
            ->where('name', 'like', '%' . $query . '%')
            ->get('name', 'id');
        return response()->json($patientlist);
    }

    //function to generate fingerprint ids
    public function generateFingerprintId()
    {
        //get all used fingerprint ids (already in the database)
        $usedIds = DB::table('fingerprints')->pluck('fingerprint_no')->toArray();

        //look for unused ids between 1 and 127
        $availableIds = array_diff(range(1, 127), $usedIds);

        //take the minimum id value from the available ids
        $fingerprint_no = min($availableIds);

        //return the fingerprint id
        return response()->json(['fingerprint_no' => $fingerprint_no]);

        }

    //function to save the patient and fingerprint id generated to database
    public function savetodatabase(Request $request)
    {
        Log::info($request->input('query1'));
        //receiving the patient and fingerprint id from the modal
        $query1 = $request->input('query1');
        $query2 = $request->input('query2');

        //saving them to database
        //checking if the fields are not empty
        if (request()->filled('query1') && request()->filled('query2')) {
                DB::table('patients')
                    ->where('name', $query1)
                    ->whereNull('fingerprint_no')
                    ->update(['fingerprint_no' => $query2]);
        }
        // send error message if fields are empty
        else{
            return response('empty fields', 500)->with('message', 'fields can not be empty');
        }

        return response()->json($query1);
    }

    public function RegisterNewFingerprint(Request $request)
    {
        $query1 = $request->input('query1');
        $query2 = $request->input('query2');

        $data = DB::table('patients')
                    ->whereNotNull('fingerprint_no')
                    ->where('status', false)
                    ->get();
        $patient = $data[0];

        return response()->json(['patient_id' => $patient->id, 'fingerprint_no' => $patient->fingerprint_no, 'code' => 200 ]);

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

        Patient::where('id', $data['patient_id'])
                ->where('fingerprint_no' , $data['fingerprint_no'])
                ->update([
                    'status' => true,
                ]);

        // Patient::where('id',$request->input('patient_id'))
        //             ->where('fingerprint_no' , $request->input('fingerprint_no'))
        //             ->update([
        //                 'status' => 'TRUE',
        //             ]);

        // Return a success response
        return response()->json(['code' => 200, 'message'=>'Request sent successfully']);
    }

    // public function searchget($str)
    // {
    //     $patientlist = DB::table('patients')
    //         ->where('name', 'like', '%' . $str . '%')
    //         ->get('name', 'id');
    //     return response()->json($patientlist);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('patient.index', ['patients' => Patient::latest()->paginate(5)]);

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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        return view('patient.show',['patient' => $patient] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect(route('patients.index'))->with('message', 'patient deleted successfully!');
    }
}

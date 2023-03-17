<?php

namespace App\Http\Controllers;

use console;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function RegisterFingerprint()
    {
        // $usedIds = DB::table('patients')->pluck('fingerprint_no')->toArray();
        // $availableIds = array_diff(range(1, 127), $usedIds);
        // $fingerprint_no = min($availableIds);

        $fingerprint_no = rand(1, 127);

        $patient = new Patient();
        $existingIds = $patient->pluck('id')->toArray();

        while (in_array($fingerprint_no, $existingIds)) {
            $fingerprint_no = rand(1, 127);
        }

        // Send the next ID back to your IoT device
        return response()->json(['patient_id' => 1, 'fingerprint_no' => $fingerprint_no, 'code' => 200 ]);
    }

    public function savefingerprint(Request $request)
            {
                $validator = Validator::make($request->all(), [
                    'fingerprint_no' => 'required|numeric',
                    'patient_id' => 'required',
                ]);

                if ($validator->fails()) {
                    return $this->sendError('VALIDATION_ERROR', $validator->errors());
                }

                // Get the valid data sent by the IoT device
                $data = $validator->validated();

                Patient::where('id', $data['patient_id'])
                        ->where('fingerprint_no' , $data['fingerprint_no'])
                        ->update([
                            'status' => 'TRUE',
                        ]);

                // Return a success response
                return response()->json(['code' => 200, 'message'=>'Request sent successfully']);
            }

            public function search(Request $request)
            {
                $query = $request->input('query');
                $patientlist = DB::table('patients')
                    ->where('name', 'like', '%' . $query . '%')
                    ->get('name', 'id');
                return response()->json($patientlist);
            }

            public function generateFingerprintId()
            {
                $usedIds = DB::table('patients')->pluck('fingerprint_no')->toArray();
                $availableIds = array_diff(range(1, 127), $usedIds);
                $fingerprint_no = min($availableIds);
                return response()->json(['fingerprint_no' => $fingerprint_no]);

                }

            public function savetodatabase(Request $request)
            {
                $query1 = $request->input('query1');
                $query2 = $request->input('query2');

                DB::table('patients')
                    ->where('name', $query1)
                    ->whereNull('fingerprint_no')
                    ->update(['fingerprint_no' => $query2]);

                return response()->json($query1+$query2);
            }

            public function RegisterNewFingerprint(Request $request)
            {
                $query1 = $request->input('query1');
                $query2 = $request->input('query2');

                $patient_id = DB::table('patients')
                            ->where('fingerprint_no', $query2)
                            ->where('status', 'null')
                            ->get('id');

                return response()->json(['patient_id' => $patient_id, 'fingerprint_no' => $query2, 'code' => 200 ]);

            }

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
        //
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
        //
    }
}

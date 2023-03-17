<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

            // public function generateIds()
            // {
            //     // Get the last generated ID from the clients table
            //     $lastId = DB::table('clients')->max('fingerprint_no');

            //     // Generate the next ID sequentially between 1 and 127
            //     $nextId = $lastId % 127 + 1;

            //     if (!$nextId) {
            //         // Return an error response if there are no available IDs
            //         return response()->json(['error' => 'No available IDs'], 400);
            //     }

            //     // Send the next ID back to your IoT device
            //     $data = ['fingerprint_no' => $nextId];
            //     return response()->json($data);
            // }

            public function saving(Request $request)
            {
                $validator = Validator::make($request->all(), [
                    'fingerprint_no' => 'required|numeric',
                    'patient_id' => 'required',
                    'status' => 'required',
                ]);

                if ($validator->fails()) {
                    return $this->sendError('VALIDATION_ERROR', $validator->errors());
                }

                // Get the valid data sent by the IoT device
                $data = $validator->validated();

                Client::create([
                    'fingerprint_no' =>  $data['fingerprint_no'],
                    'patient_id' => $data['patient_id'],
                    'status' =>  $data['status'],
                    'cardNo' => '',
                ]);

                // Return a success response
                return response()->json(['code' => 200, 'message'=>'Request sent successfully']);
            }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('client.index', ['clients' => Client::latest()->paginate(5)]);
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
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}

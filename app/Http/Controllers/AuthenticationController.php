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
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AuthenticationController extends Controller
{
    private $username;
    private $password;
    private $url;

    public function __construct()
    {
        $this->username = "admin";
        $this->password = "Admin123";
        $this->url = "https://icare-student.dhis2.udsm.ac.tz/openmrs/ws/rest/v1/visit";
    }

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
                    // return response()->json(['code'=> 204, 'message'=>'Existing record']);
                    return response()->json(null, 204);
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

                    return response()->json(null, 200);

                    return redirect(route('authentications.index'))->with('message', 'Auth detail added successfully!');
                }
            }

            if ($request_flag == "OUT"){
                Authentication::where('fingerprint_id', $recognized_finger_print->fingerprint_no)
                                    ->where('authentication_status', true)
                                    ->delete();

                return response()->json(null, 200);

                return redirect(route('authentications.index'))->with('message', 'Patient Out!');
            }

        }

        else {
            return response()->json(null, 400);
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

    //start visit page
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
            return view('authentication.startvisit', compact('visitTypes', 'authenticatedmember'));
        }
        else if($authenticatedmember->card_status === 'not active') {
            return back()->with('error', 'NHIF member card is not active');
        }
        else{
            return back()->with('error', 'NHIF member does not exist');
        }
    }

    //start visit in icare
    public function handlestartvisit(Request $request)
    {
        // Get the patient from the form
        $patient = $request->input('patient');
        // Extract the first name from the patient
        $patientName = explode(' ', $patient)[0];

        // Step 1: Fetch patient UUID from icare API
        $patientdata = $this->fetchPatientDataFromIcare($patientName);
        $patientuuid = $patientdata[0]['uuid'];

        // Step 2: Prepare data payload for the second application's API
        $data = [
            'patient' => $patientuuid,
            'visitType' => $request->input('visitType'),
            'location' => "4748646b-81b0-4d76-81e5-7957469d4ab5",
            'attributes' => [],
            'startDatetime' => date('Y-m-d H:i:s'),
            'stopDatetime' => "2023-08-05T13:42:34.000+0000",
            'indication' => "hello there",
            'encounters' => [
                "37ecb524-6c5a-4793-a449-cab1be102199"
            ]
        ];

        $jsonString = '{
            "attributes": [
                {
                    "attributeType": "PSCHEME0IIIIIIIIIIIIIIIIIIIIIIIATYPE",
                    "value": "274f186c-a9c0-4f37-a3c8-5b18f61353b3"
                },
                {
                    "attributeType": "INSURANCEIIIIIIIIIIIIIIIIIIIIIIATYPE",
                    "value": "00000105IIIIIIIIIIIIIIIIIIIIIIIIIIII"
                },
                {
                    "attributeType": "INSURANCEIDIIIIIIIIIIIIIIIIIIIIATYPE",
                    "value": "3456789034567"
                },
                {
                    "attributeType": "INSURANCEAUTHNOIIIIIIIIIIIIIIIIATYPE",
                    "value": "NOT_AUTHORIZED"
                },
                {
                    "attributeType": "PTYPE000IIIIIIIIIIIIIIIIIIIIIIIATYPE",
                    "value": "00000101IIIIIIIIIIIIIIIIIIIIIIIIII"
                },
                {
                    "attributeType": "SERVICE0IIIIIIIIIIIIIIIIIIIIIIIATYPE",
                    "value": "368826cf-1756-41fb-89d6-65091f90b40c"
                },
                {
                    "attributeType": "66f3825d-1915-4278-8e5d-b045de8a5db9",
                    "value": "00000005IIIIIIIIIIIIIIIIIIIIIIIIII"
                },
                {
                    "attributeType": "6eb602fc-ae4a-473c-9cfb-f11a60eeb9ac",
                    "value": "4748646b-81b0-4d76-81e5-7957469d4ab5"
                }
            ]
        }';

        $vtype = $request->input('visitType');
        $cardNo = $request->input('CardNo');
        $array = json_decode($jsonString, true);
        $data["attributes"] = array_merge($data["attributes"], $array["attributes"]);

        // Step 3: Send data to the second application's API
        $response = $this->sendDataToIcareAPI($data, $patientuuid, $vtype, $cardNo);


        // Handle the API response from the second application
        if ($response->getStatusCode() == 200) {
            // Successful response
            $responseData = json_decode($response->getBody(), true);
            dd($responseData);
            // Return a success response or redirect as needed
            return redirect()->back()->with('message', 'Visit Started successfully.');

        } else {
            // Error response
            $errorMessage = 'An error occurred while processing the API request.';

            if ($response->getStatusCode() == 400) {
                // Bad request error
                $errorMessage = 'Bad request. Please check your input data.';
            } elseif ($response->getStatusCode() == 401) {
                // Unauthorized error
                $errorMessage = 'Unauthorized request. Please authenticate.';
            } elseif ($response->getStatusCode() == 404) {
                // Not found error
                $errorMessage = 'The requested resource was not found.';
            }

            // Log the error message
            Log::error('API Error: ' . $errorMessage);

            // Redirect back to the form with an error message
            return redirect()->back()->with('error', $errorMessage);
        }

    }

    private function fetchPatientDataFromIcare($patientName)
    {
        // Make a request to the first application's API using Guzzle HTTP
        $client = new Client([
            RequestOptions::VERIFY => false,
        ]);
        $response = $client->get('https://icare-student.dhis2.udsm.ac.tz/openmrs/ws/rest/v1/patient', [
            'auth' => ['admin', 'Admin123'],
            'query' => ['q' => $patientName]
        ]);

        // Handle the API response from the second application
        if ($response->getStatusCode() == 200) {
            // Successful response
            $data = json_decode($response->getBody(), true);
            $patientdata = $data['results'] ?? null;

            Log::error('Response: ' . $patientdata[0]['uuid'] ?? null);
            return $patientdata;
        } else {
        // Error response
        $errorMessage = 'An error occurred while processing the API request.';

        if ($response->getStatusCode() == 400) {
            // Bad request error
            $errorMessage = 'Bad request. Please check your input data.';
        } elseif ($response->getStatusCode() == 401) {
            // Unauthorized error
            $errorMessage = 'Unauthorized request. Please authenticate.';
        } elseif ($response->getStatusCode() == 404) {
            // Not found error
            $errorMessage = 'The requested resource was not found.';
        }

        // Log the error message
        Log::error('API Error: ' . $errorMessage);

        // Redirect back to the form with an error message
        return redirect()->back()->with('error', $errorMessage);
        }
    }

    private function sendDataToIcareAPI($data, $patientuuid, $vtype, $cardNo)
    {
        // $client = new Client([RequestOptions::VERIFY => false,]);
        // $authorization = $this->username.':'.$this->password;
        // $headers = [
        //     'Authorization' => 'Basic '.base64_encode($authorization),
        //     'Content-Type' => 'application/json',
        //     ];

        // $response = $client->post($this->url, [
        //     'headers' => $headers, RequestOptions::JSON => $data,

        // ]);
        // $body = json_decode($response->getBody(), true);
        // Log::info('Getting Access Token From FIS Successfully');
        // return $body;



        // $jsonData = json_encode($data);
        $jsonData = '{"patient": "' . $patientuuid . '","visitType":"' . $vtype . '","location":"4748646b-81b0-4d76-81e5-7957469d4ab5","attributes":[{"attributeType":"PSCHEME0IIIIIIIIIIIIIIIIIIIIIIIATYPE","value":"274f186c-a9c0-4f37-a3c8-5b18f61353b3"},{"attributeType":"INSURANCEIIIIIIIIIIIIIIIIIIIIIIATYPE","value":"00000105IIIIIIIIIIIIIIIIIIIIIIIIIIII"},{"attributeType":"INSURANCEIDIIIIIIIIIIIIIIIIIIIIATYPE","value":"' . $cardNo . '"},{"attributeType":"INSURANCEAUTHNOIIIIIIIIIIIIIIIIATYPE","value":"AUTHORIZED"},{"attributeType":"PTYPE000IIIIIIIIIIIIIIIIIIIIIIIATYPE","value":"00000101IIIIIIIIIIIIIIIIIIIIIIIIIIII"},{"attributeType":"SERVICE0IIIIIIIIIIIIIIIIIIIIIIIATYPE","value":"368826cf-1756-41fb-89d6-65091f90b40c"},{"attributeType":"66f3825d-1915-4278-8e5d-b045de8a5db9","value":"00000005IIIIIIIIIIIIIIIIIIIIIIIIIIII"},{"attributeType":"6eb602fc-ae4a-473c-9cfb-f11a60eeb9ac","value":"4748646b-81b0-4d76-81e5-7957469d4ab5"}]}';


        // Make a request to the second application's API using Guzzle HTTP
        $client = new Client([
            RequestOptions::VERIFY => false,
        ]);
        $response = $client->post('https://icare-student.dhis2.udsm.ac.tz/openmrs/ws/rest/v1/visit',[
            'auth' => ['admin', 'Admin123'],
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $jsonData,
        ]
        );

        return redirect()->back()->with('message', 'Visit Created Succesfully');
    }
}

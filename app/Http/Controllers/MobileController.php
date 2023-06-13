<?php

namespace App\Http\Controllers;

use App\Models\NhifMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MobileController extends Controller
{

    public function login(Request $request)
    {

        $CardNo = $request->input('CardNo');
        $Surname = $request->input('Surname');

        $validator = Validator::make($request->all(), [
            'CardNo' => 'required|string|max:12|unique:nhif_members,CardNo',
            'Surname' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message'=>'Validation Failed']);
        }

        $member = NhifMember::where('CardNo', $CardNo)
                            ->where('Surname', $Surname)
                            ->first();

        if ($member) {
            // Authentication succeeded
            return response()->json(['message' => 'Login succeeded', 'member' => $member]);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Login failed'], 401);
        }
    }





}

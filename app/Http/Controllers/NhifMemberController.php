<?php

namespace App\Http\Controllers;

use App\Models\NhifMember;
use App\Models\Fingerprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NhifMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // Check for search input
        if (request('search')) {
            $nhifmembers = NhifMember::where('FirstName', 'like', '%' . request('search') . '%')
                                    ->orWhere('Surname', 'like', '%' . request('search') . '%')
                                    ->orWhere('CardNo', 'like', '%' . request('search') . '%')
                                    ->paginate(5);
        } else {
            $nhifmembers = NhifMember::latest()->paginate(5);
        }

        return view('nhif_member.index', ['nhifmembers' => $nhifmembers]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nhif_member.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'FirstName' => ['required', 'string', 'max:255'],
            'Surname' => ['required', 'string', 'max:255'],
            'MobileNo' => ['required', 'string', 'max:255'],
            'Gender' => ['required', 'string', 'max:255'],
            'CardNo' => ['required', 'string', 'max:255'],
            // 'FormFourIndexNo' => ['required', 'string', 'max:255'],
            // 'MiddleName' => ['required', 'string', 'max:255'],
            // 'AdmissionNo' => ['required', 'string', 'max:255'],
            // 'CollageFaculty' => ['required', 'string', 'max:255'],
            // 'ProgrammeOfStudy' => ['required', 'string', 'max:255'],
            // 'CourseDuration' => ['required', 'string', 'max:255'],
            // 'MaritalStatus' => ['required', 'string', 'max:255'],
            // 'DateJoiningEmployer' => ['required', 'string', 'max:255'],
            // 'DateOfBirth' => ['required', 'string', 'max:255'],
            // 'NationalID' => ['required', 'string', 'max:255'],
        ]);

        if($request->hasFile('image')){
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        NhifMember::create($validated);

        return redirect(route('nhifmembers.index'))->with('message', 'member created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NhifMember  $nhifmember
     * @return \Illuminate\Http\Response
     */
    public function show(NhifMember $nhifmember, Fingerprint $fingerprint)
    {
        Log::info($nhifmember);
        return view('nhif_member.show',['nhifMember' => $nhifmember,'fingerprint' => $fingerprint] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NhifMember  $nhifmember
     * @return \Illuminate\Http\Response
     */
    public function edit(NhifMember $nhifmember)
    {
        return view('nhif_member.edit',['nhifMember' => $nhifmember] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NhifMember  $nhifmember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NhifMember $nhifmember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NhifMember  $nhifmember
     * @return \Illuminate\Http\Response
     */
    public function destroy(NhifMember $nhifmember)
    {
        $nhifmember->delete();

        return redirect(route('nhifmembers.index'))->with('message', 'Member deleted successfully!');    }
}

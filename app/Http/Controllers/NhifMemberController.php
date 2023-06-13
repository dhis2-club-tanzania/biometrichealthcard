<?php

namespace App\Http\Controllers;

use App\Models\NhifMember;
use App\Models\Fingerprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NhifMemberController extends Controller
{
    /**
     * Display a listing of the nhifmembers.
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
     * Show the form for creating a new nhifmember.
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
        $validator = Validator::make($request->all(), [
            'FirstName' => 'required|string|max:255',
            'Surname' => 'required|string|max:255',
            'MobileNo' => 'required|string|max:10|regex:/^0\d{9}$/|unique:nhif_members,MobileNo',
            'Gender' => 'required|string|max:255',
            'CardNo' => 'required|string|max:12|unique:nhif_members,CardNo',
            'card_status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        // The data is valid, do something with it
        // $file = $request->file('image');
        // $file->store('images', 'public');

        $data = $validator->validated();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        NhifMember::create($data);

        return redirect(route('nhifmembers.index'))->with('message', 'member created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NhifMember  $nhifmember
     * @return \Illuminate\Http\Response
     */
    public function show(NhifMember $nhifmember)
    {
        // Log::info($nhifmember->fingerprint->nhif_member_id);
        $unregisteredExists = Fingerprint::where('fingerprint_status', 'unregistered')->exists();

        return view('nhif_member.show',['nhifMember' => $nhifmember, 'unregisteredExists' => $unregisteredExists] );
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

    public function mobileappusers(NhifMember $nhifmember)
    {
        $data = DB::table('nhif_members')
                    ->get();

            $user = $data[0];

        return response()->json(['user_id' => $user->id, 'nhif_name' => $user->FirstName, 'code' => 200 ]);
    }

    public function report(){
        $data = NhifMember::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                            ->groupBy('date')
                            ->get();

        $labels = [];
        $values = [];

        foreach ($data as $datum) {
            $labels[] = $datum->date;
            $values[] = $datum->count;
        }

        $dataArray = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'New Members',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                    'data' => $values,
                ],
            ],
        ];


        return view('nhif_member.report', ['dataArray' => $dataArray ]);
    }

    }

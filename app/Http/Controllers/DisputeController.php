<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dispute;
use Carbon\Carbon;
//                {{-- code === Saliha --}}
class DisputeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
     {
         $this->middleware('auth');
     }


    public function index(Request $request)
    {
    $data = Dispute::all();
    $query = Dispute::query();

    if ($request->has('email')) {
        $email = $request->input('email');
        if (is_array($email)) {
            $query->whereIn('email', $email);
        } else {
            $query->where('email', $email);
        }
    }

    if ($request->has('title')) {
        $title = $request->input('title');
        if (is_array($title)) {
            $query->whereIn('title', $title);
        } else {
            $query->where('title', $title);
        }
    }

    if ($request->has('name')) {
        $name = $request->input('name');
        if (is_array($name)) {
            $query->whereIn('name', $name);
        } else {
            $query->where('name', $name);
        }
    }

    if ($request->has('user_id')) {
        $user_id = $request->input('user_id');
        if (is_array($user_id)) {
            $query->whereIn('user_id', $user_id);
        } else {
            $query->where('user_id', $user_id);
        }
    }

    if ($request->has('user_type')) {
        $user_type = $request->input('user_type');
        if (is_array($user_type)) {
            $query->whereIn('user_type', $user_type);
        } else {
            $query->where('user_type', $user_type);
        }
    }

    if ($request->has('city')) {
        $city = $request->input('city');
        if (is_array($city)) {
            $query->whereIn('city', $city);
        } else {
            $query->where('city', $city);
        }
    }

    if ($request->has('contact')) {
        $contact = $request->input('contact');
        if (is_array($contact)) {
            $query->whereIn('contact', $contact);
        } else {
            $query->where('contact', $contact);
        }
    }

    if ($request->has('profile_link')) {
        $profile_link = $request->input('profile_link');
        if (is_array($profile_link)) {
            $query->whereIn('profile_link', $profile_link);
        } else {
            $query->where('profile_link', $profile_link);
        }
    }

    if ($request->has('dateTime')) {
        $dateTimeRange = explode(' - ', $request->input('dateTime'));
        $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
        $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');

        $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
    }
    $data = Dispute::all();
        $data = $query->get();
    return view("settings.dispute.index", compact("data"));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Dispute::findOrFail($id);
        return view("settings.dispute.show", compact("data"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

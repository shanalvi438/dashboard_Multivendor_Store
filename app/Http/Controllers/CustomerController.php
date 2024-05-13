<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $customers = User::orderBy('id', 'asc')->get();
        $query = User::query();

        if ($request->has('id')) {
            $id = $request->input('id');
            if (is_array($id)) {
                $query->whereIn('id', $id);
            } else {
                $query->where('id', $id);
            }
        }

        if ($request->has('first_name')) {
            $first_name = $request->input('first_name');
            if (is_array($first_name)) {
                $query->whereIn('first_name', $first_name);
            } else {
                $query->where('first_name', $first_name);
            }
        }

        if ($request->has('last_name')) {
            $last_name = $request->input('last_name');
            if (is_array($last_name)) {
                $query->whereIn('last_name', $last_name);
            } else {
                $query->where('last_name', $last_name);
            }
        }

        if ($request->has('gender')) {
            $gender = $request->input('gender');
            if (is_array($gender)) {
                $query->whereIn('gender', $gender);
            } else {
                $query->where('gender', $gender);
            }
        }

        if ($request->has('email')) {
            $email = $request->input('email');
            if (is_array($email)) {
                $query->whereIn('email', $email);
            } else {
                $query->where('email', $email);
            }
        }

        if ($request->has('phone1')) {
            $phone1 = $request->input('phone1');
            if (is_array($phone1)) {
                $query->whereIn('phone1', $phone1);
            } else {
                $query->where('phone1', $phone1);
            }
        }

        if ($request->has('dateTime')) {
            $dateTimeRange = explode(' - ', $request->input('dateTime'));
            $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
            $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
        }

        $customers = $query->get();
        return view('customer.customerlist', compact('customers'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function cwallet()
    {

        $customer = User::orderBy('id','asc')->get();

        return view('customer.cwallet',compact('customer'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AdvertisementOrder as ModelsAdvertisementOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class AdvertisementOrder extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function details(Request $request)
    {
        $data = ModelsAdvertisementOrder::all();
        // dd($data);
        $query = ModelsAdvertisementOrder::query();

        if ($request->has('id')) {
            $id = $request->input('id');
            if (is_array($id)) {
                $query->whereIn('id', $id);
            } else {
                $query->where('id', $id);
            }
        }

        if ($request->has('phone')) {
            $phone = $request->input('phone');
            if (is_array($phone)) {
                $query->whereIn('phone', $phone);
            } else {
                $query->where('phone', $phone);
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


        if ($request->has('dateTime')) {
            $dateTimeRange = explode(' - ', $request->input('dateTime'));
            if (count($dateTimeRange) == 2) {
                $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
                $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');

                $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
            }
        }
        $data = $query->get();
        return view('advertisementOrder.details', compact('data'));
    }

    public function SellerDetails()
    {

        $data = ModelsAdvertisementOrder::where('customer_id', Auth::user()->id)->get();
        $data1 = ModelsAdvertisementOrder::with('user', 'advertisement')->first();
        return view('advertisementOrder.sellerDetails', compact('data', 'data1'));
    }

    public function advertisementImage(Request $request)
    {
        // return dd($request->all());

        $update =  ModelsAdvertisementOrder::findOrFail($request->a_d_i);
        if ($request->hasFile('image')) {
            File::delete($update->image);
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->extension();
            $image->move('upload/advertisementSeller', $imageName);
            $update->image = 'upload/advertisementSeller/' . $imageName;
        }

        $update->update();


        Toastr::success('Advertisement Added successfully', 'Success');
        return redirect()->back();
    }

    public function advertisementOrderImageStatusUpdate(Request $request)
    {

        // dd($request->all());
        $update =  ModelsAdvertisementOrder::findOrFail($request->a_d_i_admin);
        // $update->display_status = $request->display_status;
        if ($request->display_time_start) {
            $update->display_time_start = $request->display_time_start;
            // $update->display_end_start = $request->display_end_start;
        }
        $startDate = Carbon::parse($request->display_time_start);
        $endDate = $startDate->copy()->addDays($request->days);

        $update->display_end_start = $endDate;


        $update->update();


        Toastr::success('Time Status Upated', 'Success');
        return redirect()->back();
    }

    public function advertisementOrderDisplayStatus(Request $request)
    {
        // dd($request->all());
        $update =  ModelsAdvertisementOrder::findOrFail($request->a_d_i_admin_1);
        $update->display_status = $request->display_status;
        $update->update();
        Toastr::success('Display Status Upated', 'Success');
        return redirect()->back();
    }
}

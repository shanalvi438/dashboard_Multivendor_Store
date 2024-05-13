<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderTracker;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Traits\fontAwesomeTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Notification;
use App\Models\OrderDetail;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::User()->role == 'Admin') {
            $data = OrderDetail::with('order', 'product', 'vendor')->OrderBy('id', 'desc')
                ->get();
                $totalSale = OrderDetail::with('order', 'product', 'vendor')->where('status', 'Delivered')
                ->count();
        } else {
            $data = OrderDetail::with('order',  'product', 'vendor')->where('p_vendor_id', Auth::User()->id)
                ->OrderBy('id', 'desc')
                ->get();
                $totalSale = OrderDetail::with('order',  'product', 'vendor')->where('p_vendor_id', Auth::User()->id)
                ->where('status', 'Delivered')
                ->count();
        }
        foreach ($data as $orderDetail) {

            $subcategory = Subcategory::find($orderDetail->product->subcategory_id);
            $commission = $subcategory->commission;
        //    Calculate commission based on the subcategory commission rate
            $commission = $orderDetail->p_price * $orderDetail->quantity * ($subcategory->commission / 100);

            // Add commission to the order detail object
            $orderDetail->commission = $commission;
        }
        $orders = OrderDetail::query();

        if ($request->has('id')) {
            $id = $request->input('id');
            if (is_array($id)) {
                $orders->whereIn('id', $id);
            } else {
                $orders->where('id', $id);
            }
            $query = $orders->toSql();
            Log::info($query);
            $results = $orders->get();
        }

        if ($request->has('order_id')) {
            $order_id = $request->input('order_id');
            if (is_array($order_id)) {
                $orders->whereIn('order_id', $order_id);
            } else {
                $orders->where('order_id', $order_id);
            }
            $query = $orders->toSql();
            Log::info($query);
            $results = $orders->get();
        }

        if ($request->has('name')) {
            $names = $request->input('name');
            if (is_array($names)) {
                $orders->whereHas('product', function ($query) use ($names) {
                    $query->whereIn('name', $names);
                });
            } else {
                $orders->whereHas('product', function ($query) use ($names) {
                    $query->where('name', $names);
                });
            }
        }

        if ($request->has('model_no')) {
            $model_nos = $request->input('model_no');
            if (is_array($model_nos)) {
                $orders->whereHas('product', function ($query) use ($model_nos) {
                    $query->whereIn('model_no', $model_nos);
                });
            } else {
                $orders->whereHas('product', function ($query) use ($model_nos) {
                    $query->where('model_no', $model_nos);
                });
            }
        }

        if ($request->has('sku')) {
            $skus = $request->input('sku');
            if (is_array($skus)) {
                $orders->whereHas('product', function ($query) use ($skus) {
                    $query->whereIn('sku', $skus);
                });
            } else {
                $orders->whereHas('product', function ($query) use ($skus) {
                    $query->where('sku', $skus);
                });
            }
        }

        if ($request->has('customer_name')) {
            $customers = $request->input('customer_name');
            if (is_array($customers)) {
                $orders->whereHas('order', function ($query) use ($customers) {
                    foreach ($customers as $customer) {
                        $nameParts = explode(' ', $customer);
                        $query->where('first_name', $nameParts[0])->where('last_name', $nameParts[1]);
                        $query->orWhere('first_name', $nameParts[0])->where('last_name', $nameParts[1]);
                    }
                });
            } else {
                $nameParts = explode(' ', $customers);
                $orders->where('first_name', $nameParts[0])->where('last_name', $nameParts[1]);
                $orders->orWhere('first_name', $nameParts[0])->where('last_name', $nameParts[1]);
            }
        }

        if ($request->has('commission')) {
            $commission = $request->input('commission');
            if ($commission[0] != 0) {
                if (isset($commission[1]) && $commission[0] != $commission[1]) {
                    $orders->whereHas('product.subcategories', function ($query) use ($commission) {
                        $query->whereBetween('commission', [$commission[0], $commission[1]]);
                    });
                } else {
                    $orders->whereHas('product.subcategories', function ($query) use ($commission) {
                        $query->where('commission', $commission[0]);
                    });
                }
            } elseif ($commission[0] == 0 && isset($commission[1]) && $commission[1] != 0) {
                $orders->whereHas('product.subcategories', function ($query) use ($commission) {
                    $query->where('commission', '<=', $commission[1]);
                });
            }
        }
        if ($request->has('p_price')) {
            $item = $request->input('p_price');
            if ($item[0] != 0) {
            $orders = $orders->whereIn('p_price', $item);
        }
    }

    if ($request->has('dateTime')) {
        $dateTimeRange = explode(' - ', $request->input('dateTime'));
        $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
        $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');
        $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
    }

        $data = $orders->get();
        // $data = Order::orderBy('id', 'desc')->get();
        return view('sales.index', compact('data','totalSale'));
        // return response()->json($data);
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

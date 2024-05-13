<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Locations;
use App\Models\OrderDetail;
use App\Models\Notification;
use App\Models\OrderDetails;
use App\Models\OrderTracker;
use Illuminate\Http\Request;
use App\Models\vendorProfile;
use App\Traits\fontAwesomeTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class OrderController extends Controller
{
    use fontAwesomeTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $orders = Order::query();
        $query = Order::query();

        if ($request->has('id')) {
            $order_id = $request->input('id');
            if (is_array($order_id)) {
                $orders->whereIn('id', $order_id);
            } else {
                $orders->where('id', $order_id);
            }
            $query = $orders->toSql();
            Log::info($query);
            $results = $orders->get();
        }
        if ($request->has('first_name')) {
            $customer_name = $request->input('first_name');
            if (is_array($customer_name)) {
                $orders->where(function ($query) use ($customer_name) {
                    foreach ($customer_name as $name) {
                        $query->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $name . '%');
                    }
                });
            } else {
                $orders->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $customer_name . '%');
            }
        }

        if ($request->has('shipping_city')) {
            $shipping_city = $request->input('shipping_city');
            if (is_array($shipping_city)) {
                $orders->whereIn('shipping_city', $shipping_city);
            } else {
                $orders->where('shipping_city', $shipping_city);
            }
        }


        if ($request->has('total_price') && $request->has('total_price')) {
            $min_price = $request->input('total_price');
            $max_price = $request->input('total_price');
            if ($min_price != 0) {
                if ($max_price > $min_price) {
                    $orders->whereBetween('total_price', [$min_price, $max_price]);
                } else {
                    $orders->where('total_price', $min_price);
                }
            }
        }


        if ($request->has('dateTime')) {
            $dateTimeRange = explode(' - ', $request->input('dateTime'));
            $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
            $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');

            $orders->whereBetween('created_at', [$startDateTime, $endDateTime]);
        }

        if (Auth::user()->role === 'Admin') {
            $allorders = Order::count();
            $allparcels = OrderDetail::count();
            $created_at = date('Y-m-d H:i:s');
            $data = Order::orderBy('id', 'desc')->get();
        } else {
            $allorders = Order::whereHas('orderDetails', function($query){
                $query->where('p_vendor_id', Auth::user()->id);
            })->count();

            $allparcels = OrderDetail::where('p_vendor_id', Auth::user()->id)->count();

            $data = Order::whereHas('orderDetails', function ($query) {
                $query->where('p_vendor_id', Auth::user()->id);
            })
            ->orderBy('id', 'desc')
            ->get();
        }
        $data = $orders->get();
        return view('orders.allorders', compact('data', 'orders','allorders','allparcels'));
    }


    public function OrderDetailIndex(Request $request)
    {
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
        // if ($request->has('name')) {
        //     $names = $request->input('name');
        //     if (is_array($names)) {
        //         $orders->whereHas('vendor', function ($query) use ($names) {
        //             $query->whereIn('name', $names);
        //         });
        //     } else {
        //         $orders->whereHas('vendor', function ($query) use ($names) {
        //             $query->where('name', $names);
        //         });
        //     }
        // }

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

        if ($request->filled('status')) {
            $statuses = $request->input('status');
            $orders->whereIn('status', $statuses);
        }

        if ($request->has('p_price')) {
            $item = $request->input('p_price');
            $orders->whereHas('order', function ($orders) use ($item) {
                $orders->whereIn('p_price', $item);
            });
        }

        if ($request->has('dateTime')) {
            $dateTimeRange = explode(' - ', $request->input('dateTime'));
            $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
            $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');

            $orders->whereBetween('created_at', [$startDateTime, $endDateTime]);
        }

        if (Auth::User()->role == 'Admin') {
            $data = OrderDetail::with('order', 'product', 'vendor','order_tracker')->OrderBy('id', 'desc')
                ->get();
        } else {
            $data = OrderDetail::with('order', 'product', 'vendor','order_tracker')->where('p_vendor_id', Auth::User()->id)
                ->OrderBy('id', 'desc')
                ->get();
        }

        $data = $orders->get();
        // $data = Order::orderBy('id', 'desc')->get();
        // dd($data);
        // return response()->json([$data]);
        return view('orders.order_details', compact('data'));
    }


    public function order_details_status(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            // 'order_id' => 'required',
            'status' => 'required' ,
            // 'id' => 'required',
        ], [
            'status.required' => 'The status field is required',
        ]);

        $order_status = OrderDetail::where('id', $request->id)->first();

        if ($order_status->status != $request->status) {
            $order_status->status = $request->status;
            $order_status->update();

            $order_tracker = new OrderTracker;
            $order_tracker->order_id = $request->id;
            $order_tracker->status = $request->status;
            $order_tracker->datetime = Carbon::now();
            $order_tracker->save();
        }else
        {
            return redirect()->back()->with(Toastr::error('error','This status field is already Updated'));
        }

$query = OrderDetail::query();

if ($request->has('dateTime')) {
    $dateTimeRange = explode(' - ', $request->input('dateTime'));
    $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
    $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');

    $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
}
$data = $query->get();

        return redirect()->back()->with(Toastr::success('Status Updated Successfully!'));
    }public function GetOrderDetailStatus(Request $request, $id)
    {
        $status = OrderTracker::where('order_id', $id)->orderBy('datetime', 'asc')->get();
        $orders = OrderTracker::where('order_id', $id); // Filter orders by $id
$query = OrderTracker::query();
        if ($request->has('order_id')) {
            $order_ids = $request->input('order_id');
            $orders->whereIn('order_id', $order_ids);
        }

        if ($request->filled('status')) {
            $statuses = $request->input('status');
            $orders->whereIn('status', $statuses);
        }

        if ($request->has('dateTime')) {
            $dateTimeRange = explode(' - ', $request->input('dateTime'));
            $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
            $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');

            $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
        }

        $data = $orders->get();

        return view('orders.getOrderDetailStatus', compact('status', 'data'));
    }



    public function showOrders()
    {
    if (Auth::user()->role == 'Vendor') {
        $routeName = Route::currentRouteName();

            if ($routeName === 'pendingorders') {
                $data = OrderDetail::with('order', 'product', 'vendor')->where('p_vendor_id', Auth::User()->id)
                    ->where('status', '=', 'In Process')->orderBy('id', 'desc')->get();
                return view('orders.pendingorders', compact('data'));
            }
            if ($routeName === 'confirmedorders') {
                $data = OrderDetail::with('order', 'product', 'vendor')->where('p_vendor_id', Auth::User()->id)
                    ->where('status', '=', 'Confirmed')->orderBy('id', 'desc')->get();
                return view('orders.confirmedorders', compact('data'));
            }
            if ($routeName === 'packagingorders') {
                $data = OrderDetail::with('order', 'product', 'vendor')->where('p_vendor_id', Auth::User()->id)
                    ->where('status', '=', 'Packaging')->orderBy('id', 'desc')->get();
                return view('orders.packagingorders', compact('data'));
            }
            if ($routeName === 'outofdelivery') {
                $data = OrderDetail::with('order', 'product', 'vendor')->where('p_vendor_id', Auth::User()->id)
                    ->where('status', '=', 'Out For Delivery')->orderBy('id', 'desc')->get();
                return view('orders.outofdelivery', compact('data'));
            }
            if ($routeName === 'delivered') {
                $data = OrderDetail::with('order', 'product', 'vendor')->where('p_vendor_id', Auth::User()->id)
                    ->where('status', '=', 'Delivered')->orderBy('id', 'desc')->get();
                return view('orders.delivered', compact('data'));
            }
            if ($routeName === 'returned') {
                $data = OrderDetail::with('order', 'product', 'vendor')->where('p_vendor_id', Auth::User()->id)
                    ->where('status', '=', 'Returned')->orderBy('id', 'desc')->get();
                return view('orders.returned', compact('data'));
            }
            if ($routeName === 'ftod') {
                $data = OrderDetail::with('order', 'product', 'vendor')->where('p_vendor_id', Auth::User()->id)
                    ->where('status', '=', 'Failed to Deliver')->orderBy('id', 'desc')->get();
                return view('orders.ftod', compact('data'));
            }
            if ($routeName === 'canceled') {
                $data = OrderDetail::with('order', 'product', 'vendor')->where('p_vendor_id', Auth::User()->id)
                    ->where('status', '=', 'Canceled')->orderBy('id', 'desc')->get();
                return view('orders.canceled', compact('data'));
            }
            if ($routeName === 'customer_canceled') {
                $data = OrderDetail::with('order', 'product', 'vendor')->where('p_vendor_id', Auth::User()->id)
                    ->where('customer_cancel_status', '=', 'Canceled')->orderBy('id', 'desc')->get();
                return view('orders.canceled', compact('data'));
            }
        } elseif (Auth::user()->role == 'Admin') {
            $routeName = Route::currentRouteName();
            if ($routeName === 'pendingorders') {
                $data = OrderDetail::with('order', 'product', 'vendor')
                    ->where('status', '=', 'In Process')->orderBy('id', 'desc')->get();
                return view('orders.pendingorders', compact('data'));
            }
            if ($routeName === 'confirmedorders') {
                $data = OrderDetail::with('order', 'product', 'vendor')
                    ->where('status', '=', 'Confirmed')->orderBy('id', 'desc')->get();
                return view('orders.confirmedorders', compact('data'));
            }
            if ($routeName === 'packagingorders') {
                $data = OrderDetail::with('order', 'product', 'vendor')
                    ->where('status', '=', 'Packaging')->orderBy('id', 'desc')->get();
                return view('orders.packagingorders', compact('data'));
            }
            if ($routeName === 'outofdelivery') {
                $data = OrderDetail::with('order', 'product', 'vendor')
                    ->where('status', '=', 'Out For Delivery')->orderBy('id', 'desc')->get();
                return view('orders.outofdelivery', compact('data'));
            }
            if ($routeName === 'delivered') {
                $data = OrderDetail::with('order', 'product', 'vendor')
                    ->where('status', '=', 'Delivered')->orderBy('id', 'desc')->get();
                return view('orders.delivered', compact('data'));
            }
            if ($routeName === 'returned') {
                $data = OrderDetail::with('order', 'product', 'vendor')
                    ->where('status', '=', 'Returned')->orderBy('id', 'desc')->get();
                return view('orders.returned', compact('data'));
            }
            if ($routeName === 'ftod') {
                $data = OrderDetail::with('order', 'product', 'vendor')
                    ->where('status', '=', 'Failed to Deliver')->orderBy('id', 'desc')->get();
                return view('orders.ftod', compact('data'));
            }
            if ($routeName === 'canceled') {
                $data = OrderDetail::with('order', 'product', 'vendor')
                    ->where('status', '=', 'Canceled')->orderBy('id', 'desc')->get();
                return view('orders.canceled', compact('data'));
            }
            if ($routeName === 'customer_canceled') {
                $data = OrderDetail::with('order', 'product', 'vendor')
                    ->where('customer_cancel_status', '=', 'Canceled')->orderBy('id', 'desc')->get();
                return view('orders.customer_canceled', compact('data'));
            }
        }

    }

    public function GetOrderDetail(Request $request, $id){
        // $GetOrderDetails = OrderDetail::with('order', 'product', 'vendor')->where('p_vendor_id' , Auth::user()->id)->where('order_id' ,'=', $id)->get();
        // dd($GetOrderDetails);
        if(Auth::user()->role == 'Vendor')
        $GetOrderDetails = OrderDetail::with('order', 'product', 'vendor')->where('p_vendor_id' , Auth::user()->id)->where('order_id' ,'=', $id)->get();
        else{
        $GetOrderDetails = OrderDetail::with('order', 'product', 'vendor')->where('order_id' ,'=', $id) ->get();
        }

        $query = OrderDetail::query();

        if ($request->has('dateTime')) {
            $dateTimeRange = explode(' - ', $request->input('dateTime'));
            $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
            $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');

            $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
        }

        $data = $query->get();
        return view('orders.getOrderDetails',compact('GetOrderDetails'));
    }
    public function thanks($id)
    {
        $thanks = Order::findOrFail($id);
        return view('thankyou', compact('thanks'));
    }

    public function create()
    {
        return view('order.fetch_date');
    }

    public function store(Request $request)
    {
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        $order = Order::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->get();

        $order = Order::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->first();

        if ($order) {
            Notification::create([
                'user_id' => Auth::user()->id,
                'Order_id' => 'New order placed with ID ' . $order->id,
            ]);

            $order->status = $request->status;
            $order->update();
        }

        return view('order.order_report', compact('fromDate', 'toDate', 'order'));
    }


    public function orderInvoice(Request $request, $id)
    {
        $vendorlogo = vendorProfile::where('vendor_id', '=', $id)->first();
        $invoice = OrderDetail::with('product','vendorProfile', 'vendor','order_tracker')->where('order_id' ,'=', $id)->first();
        $invoiceProduct = OrderDetail::where('order_id' ,'=', $id)->get();
        // dd($invoice, $invoiceProduct,$vendorlogo);
        return view('orders.invoice', compact('invoice','invoiceProduct','vendorlogo'));
        

        if(Auth::user()->role == 'Vendor'){
            $vendorlogo = vendorProfile::where('vendor_id', '=', $id)->first();
            $invoice = OrderDetail::with('logo','order', 'product','vendorProfile', 'vendor','order_tracker')->where('p_vendor_id' , Auth::user()->id)->where('order_id' ,'=', $id)->first();
            $invoiceProduct = OrderDetail::with('order', 'product','vendorProfile', 'vendor','order_tracker')->where('p_vendor_id' , Auth::user()->id)->where('order_id' ,'=', $id)->get();
            return view('orders.invoice', compact('invoice','invoiceProduct','vendoplogo'));
        }
        elseif(Auth::user()->role == 'Admin')
        {
        $invoice = OrderDetail::with('order', 'product','vendorProfile', 'vendor','order_tracker')->where('order_id' ,'=', $id)->first();
        $invoiceProduct = OrderDetail::with('order', 'product','vendorProfile', 'vendor','order_tracker')->where('order_id' ,'=', $id)->get();
        return view('orders.invoice', compact('invoice','invoiceProduct'));
        }else{
            return "Unauthorized";
        }

    }

    public function show($id)
    {
        $order = Order::with(['order_details' => function ($query) {
            $query->with('products')->with('product_image')->with('vendor')->with('user');
        }])->where('id', '=', $id)->first();

        $cus = $order->order_details[0]->vendor;

        // $vendor = OrderDetails::where('customer_id',$cus->id,)->get();

        return view('orders.details', compact('order', 'cus'));


        // 	$order = Order::with(['order_details' => function ($query) {
        // 	$query->with('products')->with('product_image');
        // }])->where('id', '=', $id)->first();

        // return view('order.details', compact('order'));
    }

    public function edit($id)
    {
        $edit = Order::findOrFail($id);
        $status = array(
            '' => 'Select Option',
            'In Process' => 'In Process',
            'Your order has arrived in port' => 'Your order has arrived in port',
            'Your order has arrived in courier' => 'Your order has arrived in courier',
            'Your order has arrived in warehouse' => 'Your order has arrived in warehouse',
            'Left from warehouse' => 'Left from warehouse',
            'Left from port' => 'Left from port',
            'Left from courier' => 'Left from courier',
            'Your order has been delivered' => 'Your order has been delivered'
        );
        $locations = Locations::pluck('name', 'name');

        $orderTrackerDetails = OrderTracker::where('order_id', $id)->get();
        $data = $this->fontIndex();
        return view('order.edit_status', compact('edit', 'status', 'locations', 'orderTrackerDetails', 'data'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required',
            'status' => 'required',
            'id' => 'required',
        ], [
            'status.required' => 'The status field is required',
        ]);

        $order_status = Order::where('id', $request->id)->first();
        $order_status->status = $request->status;
        $order_status->update();

        return redirect()->back();
    }

    public function VendorOrders(Request $request)
    {
        $data = OrderDetails::with('order')->where('vendor_id', Auth::user()->id)->get();
        $query = OrderDetails::query();

        if ($request->has('dateTime')) {
            $dateTimeRange = explode(' - ', $request->input('dateTime'));
            $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
            $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
        }

        $data = $query->get();
        return view('order.vendor-index', compact('data'));
    }

    public function VendorOrderReceipt(Request $request, $id)
    {
        $order_detail = OrderDetails::with('products')->find($id);
        $order = Order::findOrFail($order_detail->order_id);

        $query = OrderDetails::query();

        if ($request->has('dateTime')) {
            $dateTimeRange = explode(' - ', $request->input('dateTime'));
            $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
            $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
        }

        $data = $query->get();
        return view('order.vendor_order_report', compact('order', 'order_detail'));
    }

    public function destroy($id)
    {
        //
    }

    public function refundedStatus($id){
        $order_detail =  OrderDetail::find($id);
        $order_detail->refund_status = 1;
        $order_detail->save();

        return redirect()->back()->with(Toastr::success('Refunded Status Updated Successfully!'));

    }
}

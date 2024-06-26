<?php

namespace App\Http\Controllers;

use App\Models\ShippingDelivery;
use Illuminate\Http\Request;

class ShippingDeliveryController extends Controller
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
    public function index()
    {
        //
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
     * @param  \App\Models\ShippingDelivery  $shippingDelivery
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingDelivery $shippingDelivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShippingDelivery  $shippingDelivery
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingDelivery $shippingDelivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShippingDelivery  $shippingDelivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShippingDelivery $shippingDelivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShippingDelivery  $shippingDelivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingDelivery $shippingDelivery)
    {
        //
    }
}

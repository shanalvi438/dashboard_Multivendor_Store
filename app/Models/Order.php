<?php

namespace App\Models;

use App\Models\OrderDetail;
use App\Models\OrderDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'date', 'first_name', 'last_name', 'company', 'country', 'address_01',
        'address_02', 'city', 'state', 'postal_code', 'phone1', 'phone2', 'email', 'comments',
        'payment_method', 'status', 'shipping', 'image', 'updatedby', 'customer_id', 'total_price', 'discount',
        'shipping_full_name','shipping_company_name','shipping_contact_number','shipping_address','shipping_city','shipping_country',
        'shipping_zipcode','shipping_state','shipping_email'
    ];

    // public function order_details()
    // {
    //     return $this->hasMany(OrderDetail::class, 'order_id')->with('vendor:id,name');
    // }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function product_orders_details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id')->with('product_details');
    }
    
    public function order_tracker()
    {
        return $this->hasMany(OrderTracker::class, 'order_id','id');
    }

}

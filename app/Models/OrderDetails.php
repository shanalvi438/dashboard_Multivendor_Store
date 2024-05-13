<?php

namespace App\Models;

use App\Models\Order;
use App\Http\Middleware\VendorOnly;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetails extends Model
{
   use HasFactory;
   protected $fillable = array(
      'order_id', 'customer_id', 'product_id', 'product_name', 'slug',
      'quantity', 'price', 'total', 'image', 'color', 'amount_old', 'amount_new',
      'conditionType', 'ship_charges', 'locatedin', 'imp_charges', 't_charges', 'oth_charges',
      'ship_days', 'brand_id', 'brand_logo', 'vendor_id', 'status',
   );

   public function order()
    {
        return $this->belongsTo(Order::class);
    }

   public function product()
   {
      return $this->belongsTo(Product::class, 'product_id');
   }

   public function product_image()
   {
      return $this->hasOne(ProductImages::class, 'pro_id');
   }

   public function vendor()
   {
      return $this->belongsTo(VendorOnly::class, 'vendor_id');
   }
   public function user()
   {
      return $this->belongsTo(User::class, 'customer_id');
   }
}

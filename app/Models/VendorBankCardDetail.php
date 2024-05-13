<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBankCardDetail extends Model
{
    use HasFactory;
    protected $table = "vendor_bank_card_details";

    protected $fillable = ['vendor_profile_id', 'vendor_id', 'card_holder_name', 'card_number', 'cvv','valid_date', 'card_type'];

    public function vendorProfile()
    {
        return $this->belongsTo(VendorProfile::class, 'vendor_profile_id');
    }
}

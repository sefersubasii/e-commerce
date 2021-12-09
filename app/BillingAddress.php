<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    public $timestamps  = false;
    protected $fillable = array('id', 'address_name', 'name', 'surname', 'phone', 'phoneGsm', 'identity_number', 'address', 'member_id', 'city', 'state', 'tax_no', 'tax_place', 'type');

    public function getFullNameAttribute()
    {
        return mb_convert_case(trim($this->name . ' ' . $this->surname), MB_CASE_TITLE, 'utf-8');
    }

    public function getCity()
    {
        return $this->hasOne(Cities::class, 'name', 'city');
    }
}

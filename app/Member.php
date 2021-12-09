<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

class Member extends Authenticatable
{
    //
    protected $guard    = "members";
    protected $appends  = ['fullname'];
    protected $fillable = ['id', 'identity_number', 'name', 'surname', 'gender', 'bday', 'email', 'phone', 'phoneGsm', 'company', 'tax_office', 'tax_number', 'password', 'group_id', 'allowed_to_mail', 'status', 'points', 'created_at', 'last_login_ip', 'last_login_at', 'last_logout_at'];
    protected $hidden   = ['password', 'remember_token', 'updated_at'];

    public function getfullnameAttribute()
    {
        return $this->name . " " . $this->surname;
    }

    public function Address()
    {
        return $this->hasOne('App\MemberAddress', 'member_id', 'id');
    }

    public function Group()
    {
        return $this->hasOne('App\MemberGroup', 'id', 'group_id');
    }

    public function getbillingAddress()
    {
        return $this->hasMany('App\BillingAddress', 'member_id', 'id');
    }

    public function getShippingAddress()
    {
        return $this->hasMany('App\ShippingAddress', 'member_id', 'id');
    }

    public function order()
    {
        return $this->hasMany('App\Order', 'member_id', 'id');
    }

    public function refundRequest()
    {
        return $this->hasMany('App\RefundRequest', 'member_id', 'id')->orderBy('created_at', 'desc');
    }

    public function scopeFilterByRequest($query, Request $request)
    {

        if ($request->has('order_no')) {

            $orderNo = $request->get('order_no');

            $query->whereHas('order', function ($query) use ($orderNo) {
                $query->where('order_no', $orderNo);
            });
        }

        if ($request->has('name')) {

            $query->where('name', 'LIKE', "%{$request->get('name')}%");
        }
        if ($request->has('surname')) {

            $query->where('surname', 'LIKE', "%{$request->get('surname')}%");
        }

        if ($request->has('status')) {

            $query->where('status', '=', $request->get('status'));
        }

        if ($request->has('groups')) {

            $query->where('group_id', '=', $request->get('groups'));
        }

        if ($request->has('company_name')) {

            $query->where('company', '=', $request->get('company_name'));
        }

        if ($request->has('email')) {

            $query->where('email', '=', $request->get('email'));
        }

        if ($request->has('register_date1') && $request->has('register_date2')) {
            //$query->where('created_at','<=',$request->get('register_date1'));
            //$query->where('created_at','>=',$request->get('register_date2'));
            $start = Carbon::parse($request->get('register_date1'))->startOfDay();
            $end   = Carbon::parse($request->get('register_date2'))->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
            //$query->dateBetween($start, $end);
        }

        if ($request->has('bday1') && $request->has('bday2')) {
            $start = Carbon::parse($request->get('bday1'))->startOfDay();
            $end   = Carbon::parse($request->get('bday2'))->endOfDay();
            $query->whereBetween('bday', [$start, $end]);
        }

        return $query;
    }

}

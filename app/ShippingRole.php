<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingRole extends Model
{
    const AREA_TYPE    = 1;
    const COUNTRY_TYPE = 2;
    const CITY_TYPE    = 3;

    public $timestamps  = false;
    protected $fillable = array('id', 'shipping_id', 'name', 'type', 'values', 'weight_price', 'fixed_price', 'free_shipping', 'weight_limit', 'desi');
    protected $appends  = array('edit', 'delete', 'company');

    public function geteditAttribute()
    {
        return "<a href=\"" . url("/admin/shippingRoles/edit") . "/" . $this->attributes["id"] . "\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute()
    {
        return "<a href='" . url("/admin/shippingRoles/delete") . "/" . $this->attributes["id"] . "' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }

    public function getCustomPricesAttribute($value)
    {
        return unserialize($value);
    }

    public function company()
    {
        return $this->belongsTo('App\Shipping', 'id', 'shipping_id')->select(['name']);
    }

    public function getcompanyAttribute()
    {
        $cc = \App\Shipping::find($this->attributes["shipping_id"]);
        return $cc;
    }

    public function cities($id)
    {
        return \App\Cities::find($id);
    }

    public function countries($id)
    {
        return \App\Countries::find($id);
    }

    public function getTypeValue(){
        $cityIds = json_decode($this->attributes['values'] ?? []);

        $value = null;
        if (count($cityIds)) {
            if ($this->attributes['type'] === self::COUNTRY_TYPE) {
                $value = $this->countries($cityIds);
            } elseif ($this->attributes['type'] == self::CITY_TYPE) {
                $value = ($this->cities($cityIds));
            }
        }

        return collect($value);
    }

    public function checkDeliveryCity($deliveryCity){
        $shippingTypeValues = $this->getTypeValue();

        switch ($this->attributes['type']) {
            case ShippingRole::CITY_TYPE:
                return boolval($shippingTypeValues->where('name', $deliveryCity)->count());
                break;
        }

        return true;
    }

    public function getShippingCities(){
        return $this->getTypeValue()->pluck('name')->implode(', ');
    }
}

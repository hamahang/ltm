<?php

namespace Hamahang\LTM\Models\ProvinceCity;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = "ltm_provinces";

    protected $casts = [
        'id' => 'string',
        'name' => 'string',
        'description' => 'string',
    ];

    public function cities()
    {
        return $this->hasMany('Hamahang\LTM\Models\ProvinceCity\City', 'province_id', 'id');
    }
    public function getDescriptionAttribute($value)
    {
        return $value?$value:"";
    }
}

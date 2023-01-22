<?php

namespace Hamahang\LTM\Models\ProvinceCity;

use Illuminate\Database\Eloquent\Model;

/**
 * Hamahang\LTM\Models\ProvinceCity\City
 *
 * @property-read mixed $description
 * @property-read \Hamahang\LTM\Models\ProvinceCity\Province $province
 * @mixin \Eloquent
 */
class City extends Model
{
    protected $table = "ltm_cities";

    protected $casts = [
        'id' => 'string',
        'name' => 'string',
        'description' => 'string',
        'province_id' => 'string',
        'lng' => 'string',
        'lat' => 'string',
    ];

    public function province()
    {
        return $this->belongsTo('Hamahang\LTM\Models\ProvinceCity\Province', 'province_id');
    }

    public function getDescriptionAttribute($value)
    {
        return $value ? $value : "";
    }
}

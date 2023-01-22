<?php

if (!function_exists('ltm_get_province_tree'))
{
    function ltm_get_province_tree($filter_province_ids = false, $filter_city_ids = false)
    {
        $provinces = \Hamahang\LTM\Models\ProvinceCity\Province::with(
            [
                'cities' => function ($query) use ($filter_city_ids) {
                    $query->select('id', 'name as text', 'province_id');
                    if ($filter_city_ids)
                    {
                        $query->whereIn('city.id', $filter_city_ids);
                    }
                }])->select('id', 'name as text');
        if ($filter_province_ids)
        {
            $provinces = $provinces->whereIn('id', $filter_province_ids);
        }
        return $provinces->get();


    }
}

<?php

namespace App\Traits;

trait Models
{
    /**
     * @return string
     */
    public function getEncodedIdAttribute()
    {
        return ltm_encode_ids([$this->id]);
    }
}

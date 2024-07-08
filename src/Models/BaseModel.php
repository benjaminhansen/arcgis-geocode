<?php

namespace BenjaminHansen\ArcGIS\Geocode\Models;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class BaseModel
{
    public function __construct($data)
    {
        foreach($data as $key => $value)
        {
            $this->$key = $value;
        }
    }
}

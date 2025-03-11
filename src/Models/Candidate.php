<?php

namespace BenjaminHansen\ArcGIS\Geocode\Models;

class Candidate extends BaseModel
{
    public function latitude(?float $precision = null): ?float
    {
        $latitude = $this?->location?->y ?? null;

        if ($precision && $latitude) {
            return round($latitude, $precision);
        }

        return $latitude;
    }

    public function longitude(?float $precision = null): ?float
    {
        $longitude = $this?->location?->x ?? null;

        if ($precision && $longitude) {
            return round($longitude, $precision);
        }

        return $longitude;
    }
}

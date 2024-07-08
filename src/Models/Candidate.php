<?php

namespace BenjaminHansen\ArcGIS\Geocode\Models;

class Candidate extends BaseModel
{
    public function latitude(): float|null
    {
        return $this?->location?->y ?? null;
    }

    public function longitude(): float|null
    {
        return $this?->location?->x ?? null;
    }
}

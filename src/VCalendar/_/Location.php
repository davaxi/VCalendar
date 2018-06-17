<?php

namespace  Davaxi\VCalendar\_;

/**
 * Trait Location
 * @package Davaxi\VCalendar\_
 */
Trait Location
{
    /**
     * @var string
     */
    protected $location;

    /**
     * @var float
     */
    protected $locationLat;

    /**
     * @var float
     */
    protected $locationLng;

    /**
     * @param $location
     * @param $locationLat
     * @param $locationLng
     */
    public function setLocation($location, $locationLat = null, $locationLng = null)
    {
        $this->location = $location;
        if (!is_null($locationLat)) {
            $this->locationLat = $locationLat;
        }
        if (!is_null($locationLng)) {
            $this->locationLng = $locationLng;
        }
    }

    /**
     * @param array $result
     */
    protected function computeLocation(array &$result)
    {
        if (!is_null($this->locationLat) && !is_null($this->locationLng)) {
            $result[] = sprintf('GEO:%s;%s', $this->locationLat, $this->locationLng);
        }
        $result[] = sprintf('LOCATION:%s', $this->getValue($this->location));
    }
}
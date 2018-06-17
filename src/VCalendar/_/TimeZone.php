<?php

namespace Davaxi\VCalendar\_;

/**
 * Trait TimeZone
 * @package Davaxi\VCalendar\_
 */
Trait TimeZone
{
    /**
     * @var string
     */
    protected $timeZone;

    /**
     * @param $timeZone string
     */
    public function setTimeZone($timeZone)
    {
        if (!in_array($timeZone, timezone_identifiers_list())) {
            throw new \InvalidArgumentException('Invalid timeZone: ' . $timeZone);
        }
        $this->timeZone = $timeZone;
    }

    /**
     * @param array $result
     */
    protected function computeTimeZone(array &$result)
    {
        if ($this->eventAllDay) {
            return;
        }

        $result[] = 'BEGIN:VTIMEZONE';
        $result[] = sprintf('TZID:%s', $this->timeZone);
        $result[] = sprintf('X-LIC-LOCATION:%s', $this->timeZone);
        $result[] = 'END:VTIMEZONE';
    }
}
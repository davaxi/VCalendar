<?php

namespace Davaxi\VCalendar\_;

/**
 * Trait Moment
 * @package Davaxi\VCalendar\_
 */
Trait Moment
{
    /**
     * @var boolean
     */
    protected $eventAllDay = false;

    /**
     * @var integer
     */
    protected $startDateTime;

    /**
     * @var integer
     */
    protected $endDateTime;

    public function hasEventAllDay()
    {
        $this->eventAllDay = true;
    }

    /**
     * @param $dateTime string
     */
    public function setStartDateTime($dateTime)
    {
        $dateTimeEpoch = strtotime($dateTime);
        if (!$dateTimeEpoch) {
            throw new \InvalidArgumentException('Invalid representation of start date time: ' . $dateTime);
        }
        $this->startDateTime = $dateTimeEpoch;
    }

    /**
     * @param $dateTime string
     */
    public function setEndDateTime($dateTime)
    {
        $dateTimeEpoch = strtotime($dateTime);
        if (!$dateTimeEpoch) {
            throw new \InvalidArgumentException('Invalid representation of end date time: ' . $dateTime);
        }
        $this->endDateTime = $dateTimeEpoch;
    }

    /**
     * @param $dateTime
     * @return bool|string
     */
    protected function getDateTimeFormat($dateTime)
    {
        return date('Ymd\THis', $dateTime);
    }

    /**
     * @param $dateTime
     * @return bool|string
     */
    protected function getDateFormat($dateTime)
    {
        return date('Ymd', $dateTime);
    }

    /**
     * @param array $result
     */
    protected function computeMoment(array &$result)
    {
        if ($this->eventAllDay) {
            $result[] = sprintf('DTSTART;VALUE=DATE:%s',
                $this->getDateFormat($this->startDateTime)
            );
            $result[] = sprintf('DTEND;VALUE=DATE:%s',
                $this->getDateFormat(strtotime('+1 day', $this->endDateTime))
            );
            return;
        }
        $result[] = sprintf('DTSTART;TZID=%s:%s',
            $this->timeZone,
            $this->getDateTimeFormat($this->startDateTime)
        );
        $result[] = sprintf('DTEND;TZID=%s:%s',
            $this->timeZone,
            $this->getDateTimeFormat($this->endDateTime)
        );
    }
}
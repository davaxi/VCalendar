<?php

namespace Davaxi\VCalendar\_;

/**
 * Trait File
 * @package Davaxi\VCalendar\_
 */
Trait File
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * Based on https://en.wikipedia.org/wiki/ICalendar
     * @return string
     */
    public function getContent()
    {
        $result[] = 'BEGIN:VCALENDAR';
        $result[] = 'VERSION:2.0';

        $this->computeProcess($result);

        $result[] = 'CALSCALE:GREGORIAN';
        $result[] = sprintf('METHOD:%s', $this->method);

        if ($this->calendarName){
            $result[] = sprintf('X-WR-CALNAME:%s', $this->calendarName);
        }
        // https://msdn.microsoft.com/en-us/library/ee203486(v=exchg.80).aspx
        $result[] = 'X-MS-OLK-FORCEINSPECTOROPEN:TRUE';

        $this->computeTimeZone($result);

        $result[] = 'BEGIN:VEVENT';
        $result[] = sprintf('DTSTAMP:%sZ',
            $this->getDateTimeFormat($this->lastUpdatedDatetime)
        );

        $this->computeMoment($result);

        $result[] = sprintf('STATUS:%s', $this->status);
        $result[] = sprintf('SUMMARY:%s', $this->getValue($this->title));
        $result[] = sprintf('DESCRIPTION:%s', $this->description);

        $this->computeOrganize($result);

        $result[] = sprintf('CLASS:%s', $this->class);
        $result[] = sprintf('CREATED:%sZ', $this->getDateTimeFormat($this->createdDateTime));

        $this->computeLocation($result);

        $result[] = sprintf('URL:%s', $this->getValue($this->url));
        $result[] = sprintf('SEQUENCE:%s', $this->sequence);
        $result[] = sprintf('LAST-MODIFIED:%sZ', $this->getDateTimeFormat($this->lastUpdatedDatetime));
        $result[] = sprintf('CATEGORIES:%s', implode(', ', $this->categories));

        $this->computeAttendee($result);

        $result[] = "TRANSP:OPAQUE";
        $result[] = sprintf('UID:%s', $this->uid);
        $result[] = 'END:VEVENT';
        $result[] = 'END:VCALENDAR';

        return implode("\r\n", $result);
    }
        /**
     * @return string
     */
    public function getContentType()
    {
        return 'application/ics; method=PUBLISH; charset=UTF-8';
    }

    /**
     * @param $value
     * @return string
     */
    protected function getValue($value)
    {
        return addcslashes($value, ',;');
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return sprintf('%s.ics', $this->filename);
    }

    /**
     * Stream file
     */
    public function stream()
    {
        header("Content-type: application/ics; method=PUBLISH; charset=UTF-8");
        header(sprintf("Content-Disposition: attachment; filename=%s", $this->getFilename()));
        header("Pragma: no-cache");
        header("Expires: 0");

        echo $this->getContent();
    }
}
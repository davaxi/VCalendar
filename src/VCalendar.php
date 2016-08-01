<?php

namespace Davaxi;

/**
 * Class VCalendar
 * @package Davaxi
 */
class VCalendar
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $calendarName;

    /**
     * @var string
     */
    protected $processOwner;

    /**
     * @var string
     */
    protected $processName;

    /**
     * @var string
     */
    protected $processVersion;

    /**
     * @var string
     */
    protected $processLang;

    /**
     * @var integer
     */
    protected $sequence;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $organizerName;

    /**
     * @var string
     */
    protected $organizerEmail;

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
     * @var string
     */
    protected $status;

    /**
     * @var array
     */
    protected $categories = array();

    /**
     * @var array
     */
    protected $attendees = array();

    /**
     * @var string
     */
    protected $timeZone;

    /**
     * @var integer
     */
    protected $createdDateTime;

    /**
     * @var integer
     */
    protected $lastUpdatedDatetime;

    /**
     * @var integer
     */
    protected $startDateTime;

    /**
     * @var integer
     */
    protected $endDateTime;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $uid;

    /**
     * VCalendar constructor.
     * @param string $filename
     */
    public function __construct($filename = 'invite')
    {
        $this->filename = $filename;
    }

    /**
     * @param $calendarName string
     */
    public function setCalendarName($calendarName)
    {
        $this->calendarName = $calendarName;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return sprintf('%s.ics', $this->filename);
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('Invalid url: ' . $url);
        }
        $this->url = $url;
    }

    /**
     * @param $processOwner string
     * @param $processName string
     * @param $processVersion string
     * @param $processLang string
     */
    public function setProcess($processOwner, $processName, $processVersion, $processLang)
    {
        $this->processOwner = $processOwner;
        $this->processName = $processName;
        $this->processVersion = $processVersion;
        $this->processLang = $processLang;
    }

    /**
     * @param $organizerName
     * @param $organizerEmail
     */
    public function setOrganizer($organizerName, $organizerEmail)
    {
        if (filter_var($organizerEmail, FILTER_VALIDATE_EMAIL) === false || preg_match('/@[a-zA-Z0-9\-]+$/', $organizerEmail)) {
            throw new \InvalidArgumentException('Invalid organizer email: ' . $organizerEmail);
        }
        $this->organizerName = $organizerName;
        $this->organizerEmail = $organizerEmail;
    }

    /**
     * @param $status
     */
    public function setStatus($status)
    {
        if (!in_array($status, array('TENTATIVE', 'CONFIRMED', 'CANCELED'))) {
            throw new \InvalidArgumentException('Invalid status: ' . $status . '. Available only TENTATIVE / CONFIRMED / CANCELED');
        }
        $this->status = $status;
    }

    /**
     * @param $class
     */
    public function setClass($class)
    {
        if (!in_array($class, array('PRIVATE', 'PUBLIC', 'CONFIDENTIAL'))) {
            throw new \InvalidArgumentException('Invalid class: ' . $class . '. Available only PRIVATE / PUBLIC / CONFIDENTIAL');
        }
        $this->class = $class;
    }

    /**
     * @param $method string
     */
    public function setMethod($method)
    {
        if (!in_array($method, array('REQUEST', 'PUBLISH'))) {
            throw new \InvalidArgumentException('Invalid method: ' . $method . '. Available only REQUEST / PUBLISH');
        }
        $this->method = $method;
    }

    /**
     * @param array $categories
     */
    public function setCategories(array $categories)
    {
        $this->categories = $categories;
    }

    /**
     * @param $sequence integer
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }

    /**
     * @param $name string
     * @param $role string
     * @param $email string
     * @param $rsvp boolean
     */
    public function addAttendee($name, $role, $email, $rsvp)
    {
        if (!in_array($role, array('CHAIR', 'REQ-PARTICIPANT', 'OPT-PARTICIPANT', 'NON-PARTICIPANT'))) {
            throw new \InvalidArgumentException('Invalid attendee role: ' . $role . '. Available only CHAIR / REQ-PARTICIPANT / OPT-PARTICIPANT / NON-PARTICIPANT');
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false || preg_match('/@[a-zA-Z0-9\-]+$/', $email)) {
            throw new \InvalidArgumentException('Invalid attendee email: ' . $email);
        }
        if (!is_bool($rsvp)) {
            throw new \InvalidArgumentException('invalid RSVP value. Only boolean is accepted');
        }

        $this->attendees[] = array(
            'name' => $name,
            'role' => $role,
            'email' => $email,
            'rsvp' => $rsvp,
        );
    }

    /**
     * @param $location
     * @param $locationLat
     * @param $locationLng
     */
    public function setLocation($location, $locationLat, $locationLng)
    {
        $this->location = $location;
        $this->locationLat = $locationLat;
        $this->locationLng = $locationLng;
    }

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
     * Generate UID
     */
    public function generateUID()
    {
        $this->uid = date('Ymd') . 'T' . date('His') . '-' . rand();
    }

    /**
     * @param $uid
     */
    public function setUID($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @param $title string
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param $description string
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param $dateTime
     */
    public function setCreatedDateTime($dateTime)
    {
        $dateTimeEpoch = strtotime($dateTime);
        if (!$dateTimeEpoch) {
            throw new \InvalidArgumentException('Invalid representation of creation date time: ' . $dateTime);
        }
        $this->createdDateTime = $dateTimeEpoch;
    }

    /**
     * @param $dateTime
     */
    public function setLastUpdatedDateTime($dateTime)
    {
        $dateTimeEpoch = strtotime($dateTime);
        if (!$dateTimeEpoch) {
            throw new \InvalidArgumentException('Invalid representation of last updated date time: ' . $dateTime);
        }
        $this->lastUpdatedDatetime = $dateTimeEpoch;
    }

    public function getContentType()
    {
        return 'application/ics; method=PUBLISH; charset=UTF-8';
    }

    /**
     * Based on https://en.wikipedia.org/wiki/ICalendar
     * @return string
     */
    public function getContent()
    {
        $result[] = 'BEGIN:VCALENDAR';
        $result[] = 'VERSION:2.0';
        $result[] = sprintf("PRODID:-//%s//%s %s//%s",
            $this->processOwner,
            $this->processName,
            $this->processVersion,
            $this->processLang
        );
        $result[] = 'CALSCALE:GREGORIAN';
        $result[] = sprintf('METHOD:%s', $this->method);
        $result[] = sprintf('X-WR-CALNAME:%s', $this->calendarName);
        // https://msdn.microsoft.com/en-us/library/ee203486(v=exchg.80).aspx
        $result[] = 'X-MS-OLK-FORCEINSPECTOROPEN:TRUE';

        $result[] = 'BEGIN:VTIMEZONE';
        $result[] = sprintf('TZID:%s', $this->timeZone);
        $result[] = sprintf('X-LIC-LOCATION:%s', $this->timeZone);
        $result[] = 'END:VTIMEZONE';

        $result[] = 'BEGIN:VEVENT';
        $result[] = sprintf('DTSTAMP:%sZ',
            $this->getDateTimeFormat($this->lastUpdatedDatetime)
        );
        $result[] = sprintf('DTSTART;TZID=%s:%s',
            $this->timeZone,
            $this->getDateTimeFormat($this->startDateTime)
        );
        $result[] = sprintf('DTEND;TZID=%s:%s',
            $this->timeZone,
            $this->getDateTimeFormat($this->endDateTime)
        );
        $result[] = sprintf('STATUS:%s', $this->status);
        $result[] = sprintf('SUMMARY:%s', $this->getValue($this->title));
        $result[] = sprintf('DESCRIPTION:%s', $this->description);
        $result[] = sprintf('ORGANIZER;CN=%s:MAILTO:%s',
            $this->getValue($this->organizerName),
            $this->getValue($this->organizerEmail)
        );
        $result[] = sprintf('CLASS:%s', $this->class);
        $result[] = sprintf('CREATED:%sZ', $this->getDateTimeFormat($this->createdDateTime));
        $result[] = sprintf('GEO:%s;%s', $this->locationLat, $this->locationLng);
        $result[] = sprintf('LOCATION:%s', $this->getValue($this->location));
        $result[] = sprintf('URL:%s', $this->getValue($this->url));
        $result[] = sprintf('SEQUENCE:%s', $this->sequence);
        $result[] = sprintf('LAST-MODIFIED:%sZ', $this->getDateTimeFormat($this->lastUpdatedDatetime));
        $result[] = sprintf('CATEGORIES:%s', implode(', ', $this->categories));

        foreach ($this->attendees as $attendee) {
            $result[] = sprintf('ATTENDEE;ROLE=%s;CN=%s:MAILTO:%s',
                $attendee['role'],
                $attendee['name'],
                $attendee['email']
            );
        }
        $result[] = "TRANSP:OPAQUE";
        $result[] = sprintf('UID:%s', $this->uid);
        $result[] = 'END:VEVENT';
        $result[] = 'END:VCALENDAR';

        return implode("\n", $result);
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
     * @param $dateTime
     * @return bool|string
     */
    protected function getDateTimeFormat($dateTime)
    {
        return date('Ymd\THis', $dateTime);
    }

    public function stream($fileName)
    {
        header("Content-type: application/ics; method=PUBLISH; charset=UTF-8");
        header(sprintf("Content-Disposition: attachment; filename=%s.ics", $fileName));
        header("Pragma: no-cache");
        header("Expires: 0");

        echo $this->getContent();
        exit();
    }

}
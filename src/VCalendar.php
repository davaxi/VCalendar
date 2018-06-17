<?php

namespace Davaxi;

use Davaxi\VCalendar\_\Attendee;
use Davaxi\VCalendar\_\File;
use Davaxi\VCalendar\_\Location;
use Davaxi\VCalendar\_\Moment;
use Davaxi\VCalendar\_\Organizer;
use Davaxi\VCalendar\_\Process;
use Davaxi\VCalendar\_\TimeZone;

/**
 * Class VCalendar
 * @package Davaxi
 */
class VCalendar
{
    use Attendee;
    use File;
    use Location;
    use Moment;
    use Organizer;
    use Process;
    use TimeZone;

    /**
     * @var string
     */
    protected $calendarName;

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
    protected $status;

    /**
     * @var array
     */
    protected $categories = array();

    /**
     * @var integer
     */
    protected $createdDateTime;

    /**
     * @var integer
     */
    protected $lastUpdatedDatetime;

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
        $this->calendarName = trim($calendarName);
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
}
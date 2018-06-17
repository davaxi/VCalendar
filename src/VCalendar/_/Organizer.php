<?php

namespace Davaxi\VCalendar\_;

/**
 * Trait Organizer
 * @package Davaxi\VCalendar\_
 */
Trait Organizer
{
    /**
     * @var string
     */
    protected $organizerName;

    /**
     * @var string
     */
    protected $organizerEmail;

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
     * @param array $result
     */
    public function computeOrganize(array &$result)
    {
        $result[] = sprintf('ORGANIZER;CN=%s:MAILTO:%s',
            $this->getValue($this->organizerName),
            $this->getValue($this->organizerEmail)
        );
    }
}
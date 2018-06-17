<?php

namespace Davaxi\VCalendar\_;

/**
 * Trait Attendee
 * @package Davaxi\VCalendar\_
 */
Trait Attendee
{
    /**
     * @var array
     */
    protected $attendees = array();

    /**
     * @var array
     */
    protected static $attendeeRoles = [
        'CHAIR',
        'REQ-PARTICIPANT',
        'OPT-PARTICIPANT',
        'NON-PARTICIPANT'
    ];

    /**
     * @param $name string
     * @param $role string
     * @param $email string
     * @param $rsvp boolean
     */
    public function addAttendee($name, $role, $email, $rsvp)
    {
        if (!in_array($role, static::$attendeeRoles)) {
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
     * @param array $result
     */
    protected function computeAttendee(array &$result)
    {
        foreach ($this->attendees as $attendee) {
            $result[] = sprintf('ATTENDEE;ROLE=%s;CN=%s:MAILTO:%s',
                $attendee['role'],
                $attendee['name'],
                $attendee['email']
            );
        }
    }
}
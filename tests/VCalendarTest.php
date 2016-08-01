<?php

use Davaxi\VCalendar as VCalendar;

class VCalendarMockup extends VCalendar
{
    public function getAttribute($attribute)
    {
        return $this->$attribute;
    }
}

class VCalendar_Test extends PHPUnit_Framework_TestCase
{
    /**
     * @var VCalendarMockup
     */
    protected $VCalendar;

    public function setUp()
    {
        parent::setUp();
        $this->VCalendar = new VCalendarMockup();
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->VCalendar);
    }

    public function testConstructDefault()
    {
        $value = $this->VCalendar->getAttribute('filename');
        $this->assertEquals('invite', $value);
    }

    public function testConstruct()
    {
        $expected = 'MyPrivateFileName';
        $this->VCalendar = new VCalendarMockup($expected);
        $value = $this->VCalendar->getAttribute('filename');
        $this->assertEquals($expected, $value);
    }

    public function testSetCalendarName()
    {
        $expected = 'MyCalendarName';
        $this->VCalendar->setCalendarName($expected);
        $value = $this->VCalendar->getAttribute('calendarName');
        $this->assertEquals($expected, $value);
    }

    public function testGetFileNameDefault()
    {
        $value = $this->VCalendar->getFilename();
        $this->assertEquals('invite.ics', $value);
    }

    public function testGetFileName()
    {
        $expected = 'MyPrivateFileName';
        $this->VCalendar = new VCalendarMockup($expected);
        $value = $this->VCalendar->getFilename();
        $this->assertEquals($expected . '.ics', $value);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetUrlInvalid()
    {
        $expected = 'invalid url';
        $this->VCalendar->setUrl($expected);
    }

    public function testSetUrl()
    {
        $expected = 'https://www.domain.com';
        $this->VCalendar->setUrl($expected);
        $value = $this->VCalendar->getAttribute('url');
        $this->assertEquals($expected, $value);
    }

    public function testSetProcess()
    {
        $processOwner = 'Davaxi';
        $processName = 'Davaxi Events';
        $processVersion = 'v1.0';
        $processLang = 'FR';
        $this->VCalendar->setProcess($processOwner, $processName, $processVersion, $processLang);

        $value = $this->VCalendar->getAttribute('processOwner');
        $this->assertEquals($processOwner, $value);

        $value = $this->VCalendar->getAttribute('processName');
        $this->assertEquals($processName, $value);

        $value = $this->VCalendar->getAttribute('processVersion');
        $this->assertEquals($processVersion, $value);

        $value = $this->VCalendar->getAttribute('processLang');
        $this->assertEquals($processLang, $value);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetOrganizerInvalidEmail()
    {
        $organizerName = 'Davaxi';
        $organizerEmail = 'invalid email';
        $this->VCalendar->setOrganizer($organizerName, $organizerEmail);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetOrganizerLocalEmail()
    {
        $organizerName = 'Davaxi';
        $organizerEmail = 'root@localhost';
        $this->VCalendar->setOrganizer($organizerName, $organizerEmail);
    }

    public function testSetOrganizer()
    {
        $organizerName = 'Davaxi';
        $organizerEmail = 'root@test.fr';
        $this->VCalendar->setOrganizer($organizerName, $organizerEmail);

        $value = $this->VCalendar->getAttribute('organizerName');
        $this->assertEquals($organizerName, $value);

        $value = $this->VCalendar->getAttribute('organizerEmail');
        $this->assertEquals($organizerEmail, $value);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetStatusInvalid()
    {
        $expected = 'Invalid value';
        $this->VCalendar->setStatus($expected);
    }
    
    public function testSetStatusTentative()
    {
        $expected = 'TENTATIVE';
        $this->VCalendar->setStatus($expected);
        $value = $this->VCalendar->getAttribute('status');
        $this->assertEquals($expected, $value);
    }

    public function testSetStatusConfirmed()
    {
        $expected = 'CONFIRMED';
        $this->VCalendar->setStatus($expected);
        $value = $this->VCalendar->getAttribute('status');
        $this->assertEquals($expected, $value);
    }

    public function testSetStatusCanceled()
    {
        $expected = 'CANCELED';
        $this->VCalendar->setStatus($expected);
        $value = $this->VCalendar->getAttribute('status');
        $this->assertEquals($expected, $value);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetClassInvalid()
    {
        $expected = 'Invalid value';
        $this->VCalendar->setClass($expected);
    }

    public function testSetClassPrivate()
    {
        $expected = 'PRIVATE';
        $this->VCalendar->setClass($expected);
        $value = $this->VCalendar->getAttribute('class');
        $this->assertEquals($expected, $value);
    }

    public function testSetClassPublic()
    {
        $expected = 'PUBLIC';
        $this->VCalendar->setClass($expected);
        $value = $this->VCalendar->getAttribute('class');
        $this->assertEquals($expected, $value);
    }

    public function testSetClassConfidential()
    {
        $expected = 'CONFIDENTIAL';
        $this->VCalendar->setClass($expected);
        $value = $this->VCalendar->getAttribute('class');
        $this->assertEquals($expected, $value);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetMethodInvalid()
    {
        $expected = 'Invalid value';
        $this->VCalendar->setMethod($expected);
    }

    public function testSetMethodRequest()
    {
        $expected = 'REQUEST';
        $this->VCalendar->setMethod($expected);
        $value = $this->VCalendar->getAttribute('method');
        $this->assertEquals($expected, $value);
    }

    public function testSetMethodPublish()
    {
        $expected = 'PUBLISH';
        $this->VCalendar->setMethod($expected);
        $value = $this->VCalendar->getAttribute('method');
        $this->assertEquals($expected, $value);
    }

    public function testSetCategories()
    {
        $expected = array('ENTERTAINMENT');
        $this->VCalendar->setCategories($expected);
        $value = $this->VCalendar->getAttribute('categories');
        $this->assertEquals($expected, $value);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddAttendeeInvalidRole()
    {
        $this->VCalendar->addAttendee('Davaxi', 'invalid role', 'test@test.fr', true);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddAttendeeInvalidEmail()
    {
        $this->VCalendar->addAttendee('Davaxi', 'REQ-PARTICIPANT', 'invalid email', true);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddAttendeeLocalEmail()
    {
        $this->VCalendar->addAttendee('Davaxi', 'REQ-PARTICIPANT', 'root@localhost', true);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddAttendeeInvalidRSVP()
    {
        $this->VCalendar->addAttendee('Davaxi', 'REQ-PARTICIPANT', 'root@localhost.fr', 'invalid');
    }

    public function testAddAttendee()
    {
        $attendees = array(
            array(
                'name' => 'Davaxi',
                'role' => 'CHAIR',
                'email' => 'email@doain.fr',
                'rsvp' => false,
            ),
            array(
                'name' => 'Davaxi 2',
                'role' => 'REQ-PARTICIPANT',
                'email' => 'email@domain.fr',
                'rsvp' => true,
            ),
            array(
                'name' => 'Davax',
                'role' => 'OPT-PARTICIPANT',
                'email' => 'email@do.fr',
                'rsvp' => false,
            ),
            array(
                'name' => 'Davaxi 4',
                'role' => 'NON-PARTICIPANT',
                'email' => 'email@da.fr',
                'rsvp' => false,
            ),
        );
        foreach ($attendees as $attendee) {
            $this->VCalendar->addAttendee(
                $attendee['name'],
                $attendee['role'],
                $attendee['email'],
                $attendee['rsvp']
            );
        }
        $value = $this->VCalendar->getAttribute('attendees');
        $this->assertEquals($attendees, $value);
    }

    public function testSetLocation()
    {
        $location = 'Paris';
        $locationLat = 48.874086;
        $locationLng = 2.345640;
        $this->VCalendar->setLocation($location, $locationLat, $locationLng);

        $value = $this->VCalendar->getAttribute('location');
        $this->assertEquals($location, $value);

        $value = $this->VCalendar->getAttribute('locationLat');
        $this->assertEquals($locationLat, $value);

        $value = $this->VCalendar->getAttribute('locationLng');
        $this->assertEquals($locationLng, $value);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetTimeZoneInvalid()
    {
        $expected = 'Invalid timezone';
        $this->VCalendar->setTimeZone($expected);
    }

    public function testSetTimeZone()
    {
        $expected = 'Europe/Paris';
        $this->VCalendar->setTimeZone($expected);
        $value = $this->VCalendar->getAttribute('timeZone');
        $this->assertEquals($expected, $value);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetStartDateInvalidString()
    {
        $this->VCalendar->setStartDateTime('invalid string');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetStartDateInvalidDateString()
    {
        $this->VCalendar->setStartDateTime('2012-24-14');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetStartDateInvalidNumeric()
    {
        $this->VCalendar->setStartDateTime(10000);
    }

    public function testSetStartDateAbsoluteDate()
    {
        $value = '2016-10-12 10:00:00';
        $this->VCalendar->setStartDateTime($value);
        $this->assertEquals(strtotime($value), $this->VCalendar->getAttribute('startDateTime'));
    }

    public function testSetStartDateRelativeDate()
    {
        $value = 'tomorrow 00:00:00';
        $this->VCalendar->setStartDateTime($value);
        $this->assertEquals(strtotime($value), $this->VCalendar->getAttribute('startDateTime'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetEndDateInvalidString()
    {
        $this->VCalendar->setEndDateTime('invalid string');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetEndDateInvalidDateString()
    {
        $this->VCalendar->setEndDateTime('2012-24-14');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetEndDateInvalidNumeric()
    {
        $this->VCalendar->setEndDateTime(10000);
    }

    public function testSetEndDateAbsoluteDate()
    {
        $value = '2016-10-12 10:00:00';
        $this->VCalendar->setEndDateTime($value);
        $this->assertEquals(strtotime($value), $this->VCalendar->getAttribute('endDateTime'));
    }

    public function testSetEndDateRelativeDate()
    {
        $value = 'tomorrow 00:00:00';
        $this->VCalendar->setEndDateTime($value);
        $this->assertEquals(strtotime($value), $this->VCalendar->getAttribute('endDateTime'));
    }

    public function testGenerateUID()
    {
        $value = $this->VCalendar->getAttribute('uid');
        $this->assertEquals('', $value);

        $this->VCalendar->generateUID();
        $value = $this->VCalendar->getAttribute('uid');
        $this->assertNotEquals('', $value);

        $this->VCalendar->generateUID();
        $secondValue = $this->VCalendar->getAttribute('uid');
        $this->assertNotEquals('', $secondValue);
        $this->assertNotEquals($value, $secondValue);
    }

    public function testSetUID()
    {
        $expected = 'PersonalUID';
        $this->VCalendar->setUID($expected);
        $value = $this->VCalendar->getAttribute('uid');
        $this->assertEquals($expected, $value);
    }

    public function testSetTitle()
    {
        $expected = 'PersonalTitle';
        $this->VCalendar->setTitle($expected);
        $value = $this->VCalendar->getAttribute('title');
        $this->assertEquals($expected, $value);
    }

    public function testSetDescription()
    {
        $expected = 'PersonalDescription';
        $this->VCalendar->setDescription($expected);
        $value = $this->VCalendar->getAttribute('description');
        $this->assertEquals($expected, $value);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetCreatedDateInvalidString()
    {
        $this->VCalendar->setCreatedDateTime('invalid string');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetCreatedDateInvalidDateString()
    {
        $this->VCalendar->setCreatedDateTime('2012-24-14');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetCreatedDateInvalidNumeric()
    {
        $this->VCalendar->setCreatedDateTime(10000);
    }

    public function testSetCreatedDateAbsoluteDate()
    {
        $value = '2016-10-12 10:00:00';
        $this->VCalendar->setCreatedDateTime($value);
        $this->assertEquals(strtotime($value), $this->VCalendar->getAttribute('createdDateTime'));
    }

    public function testSetCreatedDateRelativeDate()
    {
        $value = 'tomorrow 00:00:00';
        $this->VCalendar->setCreatedDateTime($value);
        $this->assertEquals(strtotime($value), $this->VCalendar->getAttribute('createdDateTime'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetLastUpdatedDateInvalidString()
    {
        $this->VCalendar->setLastUpdatedDateTime('invalid string');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetLastUpdatedDateInvalidDateString()
    {
        $this->VCalendar->setLastUpdatedDateTime('2012-24-14');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetLastUpdatedDateInvalidNumeric()
    {
        $this->VCalendar->setLastUpdatedDateTime(10000);
    }

    public function testSetLastUpdatedDateAbsoluteDate()
    {
        $value = '2016-10-12 10:00:00';
        $this->VCalendar->setLastUpdatedDateTime($value);
        $this->assertEquals(strtotime($value), $this->VCalendar->getAttribute('lastUpdatedDatetime'));
    }

    public function testSetLastUpdatedDateRelativeDate()
    {
        $value = 'tomorrow 00:00:00';
        $this->VCalendar->setLastUpdatedDateTime($value);
        $this->assertEquals(strtotime($value), $this->VCalendar->getAttribute('lastUpdatedDatetime'));
    }

    public function testGetContentType()
    {
        $expected = 'application/ics; method=PUBLISH; charset=UTF-8';
        $value = $this->VCalendar->getContentType();
        $this->assertEquals($expected, $value);
    }

    public function testGetContent()
    {
        $this->VCalendar->setProcess('Davaxi', 'Davaxi Events', 'v1.0', 'EN');
        $this->VCalendar->setMethod('PUBLISH');
        $this->VCalendar->setCalendarName('Events - Davaxi');
        $this->VCalendar->setTimeZone('Europe/Paris');
        $this->VCalendar->setStartDateTime('2016-06-10 10:00:00');
        $this->VCalendar->setEndDateTime('2016-06-10 14:00:00');
        $this->VCalendar->setStatus('CONFIRMED');
        $this->VCalendar->setTitle('My Event Title');
        $this->VCalendar->setDescription('My Event Description');
        $this->VCalendar->setOrganizer('Davaxi', 'root@domain.fr');
        $this->VCalendar->setClass('PUBLIC');
        $this->VCalendar->setCreatedDateTime('2016-06-01 00:00:00');
        $this->VCalendar->setLocation('Paris', 48.874086, 2.345640);
        $this->VCalendar->setUrl('https://www.domain.com/');
        $this->VCalendar->setSequence(4);
        $this->VCalendar->setLastUpdatedDateTime('2016-06-01 01:00:00');
        $this->VCalendar->setCategories(array('ENTERTAINMENT'));
        $this->VCalendar->setUID('event_davaxi_1');
        $this->VCalendar->addAttendee('Guest', 'REQ-PARTICIPANT', 'guest@domain.com',false);
        $value = $this->VCalendar->getContent();

        $dirname = dirname(__FILE__);
        $expected = file_get_contents($dirname . '/assets/invite.ics');
        $this->assertEquals($expected, $value);
    }

    /**
     * @runInSeparateProcess
     */
    public function testStream()
    {
        $this->VCalendar->setProcess('Davaxi', 'Davaxi Events', 'v1.0', 'EN');
        $this->VCalendar->setMethod('PUBLISH');
        $this->VCalendar->setCalendarName('Events - Davaxi');
        $this->VCalendar->setTimeZone('Europe/Paris');
        $this->VCalendar->setStartDateTime('2016-06-10 10:00:00');
        $this->VCalendar->setEndDateTime('2016-06-10 14:00:00');
        $this->VCalendar->setStatus('CONFIRMED');
        $this->VCalendar->setTitle('My Event Title');
        $this->VCalendar->setDescription('My Event Description');
        $this->VCalendar->setOrganizer('Davaxi', 'root@domain.fr');
        $this->VCalendar->setClass('PUBLIC');
        $this->VCalendar->setCreatedDateTime('2016-06-01 00:00:00');
        $this->VCalendar->setLocation('Paris', 48.874086, 2.345640);
        $this->VCalendar->setUrl('https://www.domain.com/');
        $this->VCalendar->setSequence(4);
        $this->VCalendar->setLastUpdatedDateTime('2016-06-01 01:00:00');
        $this->VCalendar->setCategories(array('ENTERTAINMENT'));
        $this->VCalendar->setUID('event_davaxi_1');
        $this->VCalendar->addAttendee('Guest', 'REQ-PARTICIPANT', 'guest@domain.com',false);

        ob_start();
        $this->VCalendar->stream();
        $value = ob_get_clean();

        $headers = xdebug_get_headers();
        $this->assertContains('Content-type: application/ics; method=PUBLISH; charset=UTF-8', $headers);
        $this->assertContains('Pragma: no-cache', $headers);
        $this->assertContains('Expires: 0', $headers);
        $this->assertContains('Content-Disposition: attachment; filename=invite.ics', $headers);

        $dirname = dirname(__FILE__);
        $expected = file_get_contents($dirname . '/assets/invite.ics');
        $this->assertEquals($expected, $value);
    }
}
# VCalendar

PHP Class to generate VCalendar (ics) file. Compatible with GMail Calendar attachement.

[![Build Status](https://travis-ci.org/davaxi/VCalendar.svg)](https://travis-ci.org/davaxi/VCalendar)
[![Latest Stable Version](https://poser.pugx.org/davaxi/vcalendar/version)](https://packagist.org/packages/davaxi/vcalendar)
[![Total Downloads](https://poser.pugx.org/davaxi/vcalendar/downloads)](https://packagist.org/packages/davaxi/vcalendar)
[![Latest Unstable Version](https://poser.pugx.org/davaxi/vcalendar/v/unstable)](//packagist.org/packages/davaxi/vcalendar)
[![License](https://poser.pugx.org/davaxi/vcalendar/license)](https://packagist.org/packages/davaxi/vcalendar)
[![composer.lock available](https://poser.pugx.org/davaxi/vcalendar/composerlock)](https://packagist.org/packages/davaxi/vcalendar)
[![Code Climate](https://codeclimate.com/github/davaxi/VCalendar/badges/gpa.svg)](https://codeclimate.com/github/davaxi/VCalendar)
[![Test Coverage](https://codeclimate.com/github/davaxi/VCalendar/badges/coverage.svg)](https://codeclimate.com/github/davaxi/VCalendar/coverage)
[![Issue Count](https://codeclimate.com/github/davaxi/VCalendar/badges/issue_count.svg)](https://codeclimate.com/github/davaxi/VCalendar)

## Installation

This page contains information about installing the Library for PHP.

### Requirements

- PHP version 5.3.0 or greater (including PHP 7)

### Obtaining the client library

There are two options for obtaining the files for the client library.

#### Using Composer

You can install the library by adding it as a dependency to your composer.json.

```
  "require": {
    "davaxi/vcalendar": "^1.0"
  }
```

#### Cloning from GitHub

The library is available on [GitHub](https://github.com/davaxi/VCalendar). You can clone it into a local repository with the git clone command.

```
git clone https://github.com/davaxi/VCalendar.git
```

### What to do with the files

After obtaining the files, ensure they are available to your code. If you're using Composer, this is handled for you automatically. If not, you will need to add the `autoload.php` file inside the client library.

```
require '/path/to/vcalendar/folder/autoload.php';
```

## Usage

```php
<?php

require '/path/to/vcalendar/folder/autoload.php';

$VCalendar = new Davaxi\VCalendar();
$VCalendar->setProcess('Davaxi', 'Davaxi Events', 'v1.0', 'EN');
$VCalendar->setMethod('PUBLISH');
$VCalendar->setCalendarName('Events - Davaxi');
$VCalendar->setTimeZone('Europe/Paris');
$VCalendar->setStartDateTime('2016-06-10 10:00:00');
$VCalendar->setEndDateTime('2016-06-10 14:00:00');
$VCalendar->setStatus('CONFIRMED');
$VCalendar->setTitle('My Event Title');
$VCalendar->setDescription('My Event Description');
$VCalendar->setOrganizer('Davaxi', 'root@domain.fr');
$VCalendar->setClass('PUBLIC');
$VCalendar->setCreatedDateTime('2016-06-01 00:00:00');
$VCalendar->setLocation('Paris', 48.874086, 2.345640);
$VCalendar->setUrl('https://www.domain.com/');
$VCalendar->setSequence(4);
$VCalendar->setLastUpdatedDateTime('2016-06-01 01:00:00');
$VCalendar->setCategories(array('ENTERTAINMENT'));
$VCalendar->setUID('event_davaxi_1');
$VCalendar->addAttendee('Guest', 'REQ-PARTICIPANT', 'guest@domain.com',false);
$VCalendar->stream();
exit();

```

## Documentation

```php
<?php
// Filename for download stream
$event = new Davaxi\VCalendar($fileName = 'invite');

// Set process info
$VCalendar->setProcess($processOwner, $processName, $processVersion, $processLang)

// Set method (REQUEST / PUBLISH)
$VCalendar->setMethod($method);

// Set event calendar name
$VCalendar->setCalendarName($calendarName);

// Set event timezone
$VCalendar->setTimeZone($timeZone);

// If Event on all day
$VCalendar->hasEventAllDay();

// Set event start datetime
$VCalendar->setStartDateTime($startDateTime);

// Set event end datetime
$VCalendar->setEndDateTime($endDateTime);

// Set event status (TENTATIVE / CONFIRMED / CANCELED) 
$VCalendar->setStatus($status);

// Set event title
$VCalendar->setTitle($title);

// Set event description
$VCalendar->setDescription($description);

// Set organize info
$VCalendar->setOrganizer($organizerName, $organizerEmail);

// Set event class (PUBLIC / PRIVATE / CONFIDENTIAL)
$VCalendar->setClass($class);

// Set event created datetime
$VCalendar->setCreatedDateTime($createdDateTime);

// Set event location 
$VCalendar->setLocation($locationString, $locationLat, $locationLng);

// Set event URL
$VCalendar->setUrl($url);

// Set sequence
$VCalendar->setSequence($sequence);

// Set event last updated datetime
$VCalendar->setLastUpdatedDateTime($lastUpdatedDateTime);

// Set event categories
$VCalendar->setCategories($categories);

// Set event UID (for updates)
$VCalendar->setUID($UID);

// Add attendee (types: CHAIR / REQ-PARTICIPANT / OPT-PARTICIPANT / NON-PARTICIPANT)
$VCalendar->addAttendee($name, $type, $email, $rsvp);

// Stream file with header
$VCalendar->stream();
// or get content
$content = $VCalendar->getContent();


```

## Integrate with PHPMailer with GMail direct add to calendar action

```php

$PHPMailer = new PHPMailer();
$VCalendar = new Davaxi\VCalendar();
// [...] Set VCalendar
// [...] Configure PHPMailer

$PHPMailer->addStringAttachment(
    $VCalendar->getContent(),
    $VCalendar->getFilename(),
    'base64',
    $VCalendar->getContentType(),
    'attachment'
);
$PHPMailer->Send();
```

<?php

namespace App\Tests;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\GregorianCalendarStub;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AeonCalendarControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();

        $client->getContainer()->get(GregorianCalendarStub::class)->setNow(DateTime::fromString('2020-01-01 00:00:00 America/Los_Angeles'));

        $client->request('GET', '/aeon/calendar');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('code#calendar-year', '2020');
        $this->assertSelectorTextContains('code#calendar-month', '2020-01');
        $this->assertSelectorTextContains('code#calendar-day', '2020-01-01');
        $this->assertSelectorTextContains('code#calendar-datetime', '2020-01-01T00:00:00-08:00');
    }
}

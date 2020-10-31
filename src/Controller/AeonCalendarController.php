<?php

namespace App\Controller;

use Aeon\Calendar\Gregorian\Calendar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AeonCalendarController extends AbstractController
{
    private Calendar $calendar;

    public function __construct(Calendar $calendar)
    {
        $this->calendar = $calendar;
    }

    /**
     * @Route("/aeon/calendar", name="aeon_calendar")
     */
    public function index(): Response
    {
        return $this->render('aeon_calendar/index.html.twig', [
            'calendar' => $this->calendar
        ]);
    }

    /**
     * @Route("/aeon/calendar-twig", name="aeon_calendar_twig")
     */
    public function indexTwig(): Response
    {
        return $this->render('aeon_calendar/twig.html.twig', []);
    }
}

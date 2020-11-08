<?php declare(strict_types=1);

namespace App\Controller;

use Aeon\Calendar\Gregorian\Calendar;
use App\Form\AeonFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index() : Response
    {
        return $this->render('aeon_calendar/index.html.twig', [
            'calendar' => $this->calendar,
        ]);
    }

    /**
     * @Route("/aeon/calendar-twig", name="aeon_calendar_twig")
     */
    public function indexTwig() : Response
    {
        return $this->render('aeon_calendar/twig.html.twig', []);
    }

    /**
     * @Route("/aeon/form", name="aeon_form")
     */
    public function form(Request $request) : Response
    {
        $form = $this->createForm(AeonFormType::class, null, ['calendar' => $this->calendar]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());

            die();
        }

        return $this->render('aeon_calendar/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

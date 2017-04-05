<?php

namespace AppBundle\Controller;

use AppBundle\Services\CalendarGoogle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CalendarController extends Controller
{
    public function calendarAction()
    {
       $service = $this->get('app.google_calendar');
       if(isset($_GET['p'])  && $_GET['p'] == 'list'){
           $data = $_POST;
           $aa = $service->getListEvents($data)->getItems();
           var_dump($aa);

       }elseif (isset($_GET['p'])&& $_GET['p'] == 'newevent' ){

           $data = $_POST;
           if(!isset($data['calendarId']))  $data['calendarId'] = 'primary';
           echo $service->insertEventsToCalendar($data);

       }elseif (isset($_GET['p']) && $_GET['p'] == 'deleteevent' ){

           $data = $_POST;
           $data['calendarId'] = 'primary';
           echo $service->deleteEvent($data);

       }elseif (isset($_GET['p']) && $_GET['p'] == 'updateevent'){

           $data = $_POST;
           echo $service->updateEvent($data);

       }
       elseif ($_GET['p'] == 'hello'){
           $service->retrieveAllFiles();
       }

       return $this->render('default/calendar.html.twig', [
            'text' => '',
        ]);
    }








}
<?php

namespace AppBundle\Controller;

use AppBundle\Services\CalendarGoogle;
use KofeinStyle\Helper\Dumper;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

class CalendarController extends BaseApiController
{
    public function calendarAction()
    {
        $service = $this->get('app.google_user.calendar');
        $aa = $service->getListEvents($this->getUser(),[])->getItems();


        return $this->prepareAnswer($aa);
       /*if(isset($_GET['p'])  && $_GET['p'] == 'list'){
           $data = $_POST;
           $aa = $service->getListEvents($this->getUser(),[])->getItems();
           return $this->prepareAnswer($aa);

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
        ]);*/
    }


    public function getCalendarListAction()
    {
        $service = $this->get('app.google_user.calendar');
        $list = $service->getCalendarList($this->getUser());
        $result = [];
        /**
         * @var $item \Google_Service_Calendar_CalendarListEntry
         */
        foreach ($list as $item) {
            $result[] = [
                'id' => $item->getId(),
                'accessRole' => $item->getAccessRole(),
                'summary' => $item->getSummaryOverride() ? $item->getSummaryOverride() : $item->getSummary(),
                'backgroundColor' => $item->getBackgroundColor(),
                'foregroundColor' => $item->getForegroundColor(),
            ];

        }

        return $this->prepareAnswer($result);
    }

    /**
     * @param $ids
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCalendarEventListAction($ids)
    {
        $service = $this->get('app.google_user.calendar');
        $colors = $service->getColors($this->getUser());

        if (is_null($ids) || 1==1) {
            $calendarList = $service->getCalendarList($this->getUser());
            $ids = [];
            foreach ($calendarList as $item) {
                if ( $item->getId() == '#contacts@group.v.calendar.google.com') {
                    continue;
                }
                $ids[$item->getId()] = $item->getColorId();
            }
        }

        $events = [];
        $serializer = new Serializer(array(new DateTimeNormalizer()));

        $dateAsString = $serializer->normalize(new \DateTime('2017-05-29'), \DateTime::RFC3339);
        //Dumper::dump($dateAsString);
        $params = [
            'timeMin' => $dateAsString,
            'timeMax' => '2017-05-31T23:59:59+03:00',
            'orderBy' => 'startTime',
            'singleEvents' => true

        ];

        foreach ($ids as $calendarId => $calendarColorId) {

            $result = $service->getEventLists($this->getUser(), $calendarId, $params);

            /**
             * @var $item \Google_Service_Calendar_Event
             */
            foreach ($result as $item) {
                /**
                 * @var $endDate \Google_Service_Calendar_EventDateTime
                 * @var $startDate \Google_Service_Calendar_EventDateTime
                 */

                $endDate = $item->getEnd();
                $startDate = $item->getStart();
                $eventColor_id = $item->getColorId();
                if (!empty($eventColor_id)) {
                    $backgroundColor = $colors['event'][$eventColor_id]['background'];
                    $foregroundColor = $colors['event'][$eventColor_id]['foreground'];
                } else {
                    $backgroundColor = $colors['calendar'][$calendarColorId]['background'];
                    $foregroundColor = $colors['calendar'][$calendarColorId]['foreground'];
                }


                $events[] = [
                    'id' => $item->getId(),
                    'summary' => $item->getSummary(),
                    'recurringEventId' => $item->getRecurringEventId(),
                    'startDate' => $startDate->getDateTime() ? $startDate->getDateTime() : $startDate->getDate(),
                    'endDate' => $endDate->getDateTime() ? $endDate->getDateTime() : $endDate->getDate(),
                    'status' => $item->getStatus(),
                    'backgroundColor'=> $backgroundColor,
                    'foregroundColor'=> $foregroundColor,
                ];
            }


        }


        return $this->prepareAnswer($events);
    }







}
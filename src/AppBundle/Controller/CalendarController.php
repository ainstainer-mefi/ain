<?php

namespace AppBundle\Controller;

use AppBundle\Services\CalendarGoogle;
use KofeinStyle\Helper\Dumper;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;

class CalendarController extends BaseApiController
{

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
                if ( $item->getId() != $this->getUser()->getEmail()) {
                    continue;
                }
                $ids[$item->getId()] = $item->getColorId();
            }
        }

        $events = [];
        $serializer = new Serializer([new DateTimeNormalizer()]);
        $interval = new \DateInterval('P1M');
        $dateMin = (new \DateTime())->sub($interval);
        $dateMax = (new \DateTime())->add($interval);
        $dateMinAsString = $serializer->normalize($dateMin, \DateTime::RFC3339);
        $dateMaxAsString = $serializer->normalize($dateMax, \DateTime::RFC3339);

        $params = [
            'timeMin' => $dateMinAsString,
            'timeMax' => $dateMaxAsString,
            'orderBy' => 'startTime',
            'singleEvents' => true

        ];


        foreach ($ids as $calendarId => $calendarColorId) {
            $result = $service->getEventLists($this->getUser(), $calendarId, $params);
            foreach ($result as $item) {
                $events[] = $this->formatEvent($item, $calendarId, $calendarColorId, $colors);
            }
        }


        return $this->prepareAnswer($events);
    }

    public function addUserEventAction(Request $request)
    {

        $end = $request->get('end', null);
        $start = $request->get('start', null);
        $title = $request->get('title', null);

        $data = [
            'end' => [
                'date' => $end
            ],
            'start' => [
                'date' => $start
            ],
            'summary'     => $title,
            'description' => 'description text',
            'colorId' => '4',
            'guestsCanInviteOthers' => false,
            'attendees'=> [
               //['email' => 'efimovmaksim@gmai.com','displayName' => 'Efimov Max','optional'=> true]
            ]
        ];


        $service = $this->get('app.google_user.calendar');
        $colors = $service->getColors($this->getUser());
        $event = $service->insertEventsToCalendar($this->getUser(), $data);

        return $this->prepareAnswer($this->formatEvent($event, $this->getUser()->getEmail(), 4, $colors));
    }

    public function deleteUserEventAction($id)
    {
        $service = $this->get('app.google_user.calendar');
        $service->deleteEvent($this->getUser(), $id);

        return $this->prepareAnswer();
    }

    /**
     * @param $event \Google_Service_Calendar_Event
      * @param $calendarId string
     * @return array
     */
    private function formatEvent($event, $calendarId, $calendarColorId, $colors)
    {
        /**
         * @var $endDate \Google_Service_Calendar_EventDateTime
         * @var $startDate \Google_Service_Calendar_EventDateTime
         */
        $endDate = $event->getEnd();
        $startDate = $event->getStart();

        $eventColorId = $event->getColorId();
        if (!empty($eventColorId)) {
            $backgroundColor = $colors['event'][$eventColorId]['background'];
            $foregroundColor = $colors['event'][$eventColorId]['foreground'];
        } else {
            $backgroundColor = $colors['calendar'][$calendarColorId]['background'];
            $foregroundColor = $colors['calendar'][$calendarColorId]['foreground'];
        }

        return [
            'id' => $event->getId(),
            'calendarId' => $calendarId,
            'summary' => $event->getSummary(),
            'status' => $event->getStatus(),
            'recurringEventId' => $event->getRecurringEventId(),
            'startDate' => $startDate->getDateTime() ? $startDate->getDateTime() : $startDate->getDate(),
            'endDate' => $endDate->getDateTime() ? $endDate->getDateTime() : $endDate->getDate(),
            'backgroundColor'=> $backgroundColor,
            'foregroundColor'=> $foregroundColor,
        ];
    }
}

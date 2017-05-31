<?php

namespace AppBundle\Services;


use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use KofeinStyle\Helper\Dumper;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;


class GoogleUserCalendar extends BaseGoogleUserService
{
    /**
     * @var Google_Client
     */
    protected $client = null;

    /**
     * @var Google_Service_Calendar
     */
    protected $calendarService;

    public function __construct(ContainerInterface $container = null)
    {
        parent::__construct($container);
    }


    /**
     * @param User $user
     * @return Google_Client
     * @throws \Exception
     */
    private function initClient($user)
    {
        if (!is_null($this->client)) {
            return true;
        }
        $accessToken = $user->getGoogleAccessTokenDecoded();

        $this->client = new \Google_Client();
        $this->client->setScopes($this->googleParams->getScopes());
        $this->client->setAuthConfig($this->googleParams->getClientSecretPathWeb());
        $this->client->setAccessType('offline');
        $this->client->setAccessToken($accessToken);

        $this->calendarService = new Google_Service_Calendar($this->client);
    }


    /**
     * Returns events on the calendar
     *
     * Show events for a certain period
     * example: array('timeMax' => 'YYYY-mm-ddTHH:ii:ss', 'timeMin' =>'YYYY-mm-ddTHH:ii:ss');
     *
     * @param User $user
     * @param string $calendarId
     * @return \Google_Service_Calendar_Events
     */
    public function getEventLists($user , $calendarId, $params = [])
    {
        $result = [];
        $this->initClient($user);
        $events = $this->calendarService->events->listEvents($calendarId, $params);

        while(true) {
            /**
             * @var $event \Google_Service_Calendar_Event
             */
            foreach ($events->getItems() as $event) {
                /*if (!empty($event->getRecurrence())) {
                    $recurrenceResult = $this->getEventInstances($user, $calendarId, $event->getId(), $params );
                    foreach ($recurrenceResult as $e){
                        $result[] = $e;
                    }
                } else {
                    $result[] = $event;
                }*/

                $result[] = $event;
            }
            $pageToken = $events->getNextPageToken();
            if ($pageToken) {
                $events = $this->calendarService->events->listEvents($calendarId, ['pageToken' => $pageToken]);
            } else {
                break;
            }
        }

        return $result;
    }

    /**
     * @param $user
     * @param $calendarId
     * @return mixed
     */
    public function getEventInstances($user,$calendarId, $eventId, $params)
    {
        $result = [];
        $this->initClient($user);
        $events = $this->calendarService->events->instances($calendarId, $eventId, $params);

        while(true) {
            /**
             * @var $event \Google_Service_Calendar_Event
             */
            foreach ($events->getItems() as $event) {
                $result[] = $event;
            }
            $pageToken = $events->getNextPageToken();
            if ($pageToken) {
                $events = $this->calendarService->events->instances($calendarId, $eventId, ['pageToken' => $pageToken]);
            } else {
                break;
            }
        }

        return $result;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function  getCalendarList($user)
    {
        $this->initClient($user);
        return $this->calendarService->calendarList->listCalendarList(['showHidden' => false])->getItems();
    }

    public function getColors($user)
    {
        $result = ['calendar' => [], 'event' => []];
        $this->initClient($user);
        $colors = $this->calendarService->colors->get();
        foreach ($colors->getCalendar() as $key => $color) {
            $result['calendar'][$key] = [
                'background' => $color->getBackground(),
                'foreground' => $color->getForeground(),
            ];
        }

        foreach ($colors->getEvent() as $key => $color) {
            $result['event'][$key] = [
                'background' => $color->getBackground(),
                'foreground' => $color->getForeground(),
            ];
        }

        return $result;
    }

    /**
     * Add new event to calendar
     *
     * Required parameters
     * $data = array(
     *      'end' => array(
     *          'date'     => 'YYYY-mm-dd' (if all day)
     *          'dateTime' => 'YYYY-mm-ddT09:00:00-07:00', (at a specific time, assign an event)
     *          'timeZone' => 'country/sity', (if need a time zone)
     *       ),
     *      'start' => array(
     *          'date'     => 'YYYY-mm-dd' (if all day)
     *          'dateTime' => 'YYYY-mm-ddT09:00:00-07:00', (at a specific time, assign an event)
     *          'timeZone' => 'country/sity', (if need a time zone)
     *       ),
     * );
     * optional parameters
     * array(
     *      'summary'     => 'text' (title this event)
     *      'description' => 'text'
     *      'attachments' => array(
     *          array('fileUrl' => 'url' (required)),
     *       ),
     *       'attendees'  =>  array(
     *          array('email'   => 'email')
     *       ),
     * @param array $data
     * @return \Google_Service_Calendar_Events
     */
    public function insertEventsToCalendar($data)
    {
        $client  = $this->getClient();
        $service = new Google_Service_Calendar($client);
        $event   = new Google_Service_Calendar_Event($data);
        if(!isset($data['calendarId'])) $data['calendarId'] = 'primary';
        $event   = $service->events->insert($data['calendarId'], $event);

        $eventId = $event->getId();
        if(isset($data['attachments']) && !empty($data['attachments'])){
            $this->addAttachment($service, $data['calendarId'], $eventId, $data['attachments']);
        }
        return \GuzzleHttp\json_encode($event);
    }

    /**
     * Update Event
     * Required parameters
     * array(
     *      'eventId' => 'event Id'
     * )
     * @param array $data
     * @return string
     * @throws \Exception
     */
    public function updateEvent($data){
        if(!isset($data['calendarId'])) $data['calendarId'] = 'primary';
        if(!isset($data['eventId'])){
            throw new \Exception("Missing option 'eventId'");
        }
        $client  = $this->getClient();
        $service = new Google_Service_Calendar($client);
        $event   = $service->events->get($data['calendarId'], $data['eventId']);
        foreach ($data as $k => $item) {
            $event->offsetSet($k, $item);
        }

        if($service->events->update($data['calendarId'], $event->getId(), $event)){
            if(isset($data['attachments']) && !empty($data['attachments'])){
                $this->addAttachment($service, $data['calendarId'], $data['eventId'], $data['attachments']);
            }
            $array = array(
                'status' => 'success',
                'message'=> "Event " . $data['eventId'] . " updated"
            );
            return json_encode($array);
        }

    }

    /**
     * Delete Event
     * Required parameters
     * array(
     *      'eventId' => 'event Id'
     * )
     * @param $data
     * @return string
     * @throws \Exception
     */
    public function deleteEvent($data)
    {
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);
        if(!isset($data['calendarId'])) $data['calendarId'] = 'primary';
        if($service->events->delete($data['calendarId'], $data['eventId'])){
            $array = array(
                'status' => 'success',
                'message'=> "Event " . $data['eventId'] . " deleted"
            );
            return json_encode($array);
        }else{
            throw new \Exception('Event not deleted');
        }
    }



    /**
     * Add attachments to event
     * @param $calendarService
     * @param $calendarId
     * @param $eventId
     * @param $fileUrl
     * @return bool
     */
    public function addAttachment($calendarService, $calendarId, $eventId, $fileUrl)
    {
        $changes = new Google_Service_Calendar_Event(array(
            'attachments' => $fileUrl
        ));
        $calendarService->events->patch($calendarId, $eventId, $changes, array(
            'supportsAttachments' => TRUE
        ));
        return true;

    }



}
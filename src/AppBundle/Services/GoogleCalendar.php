<?php

namespace AppBundle\Services;


use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use KofeinStyle\Helper\Dumper;
use Symfony\Component\DependencyInjection\ContainerInterface;


class GoogleCalendar extends BaseGoogleUserService
{
    /**
     * @var Google_Client
     */
    protected $client;

    /**
     * @var Google_Service_Calendar
     */
    protected $calendarService;

    public function __construct(ContainerInterface $container = null)
    {
        parent::__construct($container);
        /*$this->client = new Google_Client();
        $this->client->setApplicationName($this->googleParams->getAppName());
        $this->client->setScopes($this->googleParams->getScopes());
        $this->client->setAuthConfig($this->googleParams->getClientSecretPath());
        $this->client->setAccessType('offline');
        $this->client->setAccessToken($this->googleParams->getCredentialsData());

        $this->verifyServerToken($this->client);*/

    }


    /**
     * @return Google_Client
     * @throws \Exception
     */
    public function getClient()
    {
        /*$filesystem = new Filesystem();
        $appName = empty($this->googleParams['app_name']) ? 'My Application' : $this->googleParams['app_name'];
        $client = new Google_Client();
        $client->setApplicationName($appName);
        $client->setScopes($this->getScopes());
        $client->setAuthConfig($this->getClientSecretPath());
        $client->setAccessType('offline');
        $credentialsPath = $this->getCredentialsPath();

        if ($filesystem->exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
        } else {
            throw new \Exception('Credentials not exist');
        }
        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        }
        return $client;*/
    }


    /**
     * Returns events on the calendar
     *
     * Show events for a certain period
     * example: array('timeMax' => 'YYYY-mm-ddTHH:ii:ss', 'timeMin' =>'YYYY-mm-ddTHH:ii:ss');
     *
     * @param array $data
     * @return \Google_Service_Calendar_Events
     */
    public function getListEvents($user , $data)
    {

        ########WORKING RIGHT NOW
        $accessToken = $user->getGoogleAccessTokenDecoded();

        $this->client = new \Google_Client();
        $this->client->setScopes($this->googleParams->getScopes());
        $this->client->setAuthConfig($this->googleParams->getClientSecretPathWeb());
        $this->client->setAccessType('offline');
        $this->client->setAccessToken($accessToken);

        $this->calendarService = new Google_Service_Calendar($this->client);

        // Print the next 10 events on the user's calendar.
        if(!isset($data['calendarId'])) $data['calendarId'] = 'primary';
        $results = $this->calendarService->events->listEvents($data['calendarId'], $data);
        return $results;

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
     * Client secret path
     * @return mixed
     * @throws \Exception
     */
    public function getClientSecretPath()
    {
        if (empty($secret = $this->googleParams['client_secret_path'])) {
            throw new \Exception('Google client secret path can\'t be empty');
        }
        return $secret;
    }

    /**
     * Credentials Path
     * @return mixed
     * @throws \Exception
     */
    public function getCredentialsPath()
    {
        if (empty($credentials = $this->googleParams['credentials_path'])) {
            throw new \Exception('Google credential path can\'t be empty');
        }
        return $credentials;
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
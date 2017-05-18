<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use KofeinStyle\Helper\Dumper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class UserController extends BaseApiController
{

    /**
     *
     * @ApiDoc(
     *  description="Send email to user",
     *  parameters={
     *      {"name"="email", "dataType"="string", "required"=true, "description"="User to email"}
     *  },
     *  output="AppBundle\Entity\User"
     * )
     */
    public function secureResourceAction(Request $request)
    {

        /*$message = \Swift_Message::newInstance('Hello ','Hello Max'. date('H:i'));
        $message->setTo([$request->get('email')]);

        $data  = $this->get('app.google_user.mail')->send($this->getUser(), $message);*/

        //$data  = $this->get('app.google_drive.service')->createFolder($this->getUser());
        //$data  = $this->get('app.google_drive.service')->getUserFiles($this->getUser());
        $data  = $this->get('app.google_drive.service')->createFolder($this->getUser()->getEmail());
        return $this->prepareAnswer($data);
    }

    public function getProfileAction(Request $request)
    {
        $data = [
            'jira_accounts' => [],
            'lang' => 'en',
        ];
        $data['jira_accounts'][] = ['id'=> 1,'name' => 'Ainstainer', 'active' => 0];
        $data['jira_accounts'][] = ['id'=> 2, 'name' => 'Kopiki', 'active' => 0];
        return $this->prepareAnswer($data);
    }

    public function bindJiraAccountAction(Request $request)
    {
        return $this->prepareAnswer(['ok']);
    }
}
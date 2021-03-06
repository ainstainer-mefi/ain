<?php

namespace AppBundle\Controller;

use KofeinStyle\Helper\Dumper;
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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProfileAction()
    {
        $userId = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $jiraAccounts = $em->getRepository('AppBundle:UserBugTrackingAccounts')->getAccountsForUser($userId);

        $data = [
            'jira_accounts' => $jiraAccounts,
            'lang' => 'en',
        ];

        return $this->prepareAnswer($data);
    }

}

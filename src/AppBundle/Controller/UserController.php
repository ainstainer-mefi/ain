<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use KofeinStyle\Helper\Dumper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class UserController extends FOSRestController
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

        $message = \Swift_Message::newInstance('Hello ','Hello Max'. date('H:i'));
        $message->setTo([$request->get('email')]);

        $data  = $this->get('app.google_user.mail')->send($this->getUser(), $message);
        return $this->handleView($this->view($data, 200));
    }
}
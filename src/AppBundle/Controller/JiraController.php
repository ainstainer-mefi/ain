<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BugTrackingSystems;
use AppBundle\Entity\UserBugTrackingAccounts;
use AppBundle\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Request;

class JiraController  extends BaseApiController
{
    public function bindJiraAccountAction(Request $request)
    {
        $userId = $this->getUser()->getId();
        $serviceId = $request->get('id',0);

        $em = $this->getDoctrine()->getManager();

        $account = new UserBugTrackingAccounts();
        $account->setUserId($userId);
        $account->setCookie('cookie');
        $account->setServiceId($serviceId);

        $em->persist($account);
        $em->flush($account);

        return $this->prepareAnswer();
    }

    public function unbindJiraAccountAction(Request $request)
    {
        $userId = $this->getUser()->getId();
        $serviceId = $request->get('id',0);

        $em = $this->getDoctrine()->getManager();
        //$service = $em->getRepository('AppBundle:BugTrackingSystems')->find($systemId);

        $account = $em->getRepository('AppBundle:UserBugTrackingAccounts')->findOneBy([
            'serviceId' => $serviceId,
            'userId' => $userId
        ]);

        if ($account) {
            $em->remove($account);
            $em->flush();
        }

        return $this->prepareAnswer($account);
    }

}
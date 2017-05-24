<?php
namespace AppBundle\Repository;
use AppBundle\Entity\BugTrackingSystems;
use Doctrine\ORM\Query\Expr;
use KofeinStyle\Helper\Dumper;
class BugTrackingSystemsRepository extends \Doctrine\ORM\EntityRepository
{
    public function test()
    {

        /*$queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(['v'])
            ->from('AppBundle\\Entity\\BugTrackingSystems', 'v')
            ->leftJoin('AppBundle\\Entity\\UserBugTrackingAccounts', 'c', Expr\Join::ON, 'c.userId = 9')
            ->getQuery();
        return $queryBuilder->execute();*/
//        return $this->getEntityManager()->createQuery('SELECT u,p.userId FROM AppBundle\\Entity\\BugTrackingSystems u
//               LEFT JOIN AppBundle\\Entity\\UserBugTrackingAccounts p WHERE
//                p.serviceId=u.id')
//            ->getResult();
        //Dumper::dumpx($queryBuilder->execute());
    }
}
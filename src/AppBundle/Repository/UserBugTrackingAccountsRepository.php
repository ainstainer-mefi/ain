<?php
namespace AppBundle\Repository;


class UserBugTrackingAccountsRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $userId
     * @return array
     */
    public function getAccountsForUser($userId)
    {
        $query = 'SELECT bg.id, bg.service, bg.type, 
                (case when (user_id is not null) THEN 1 ELSE 0 END) as active
                FROM `bug_tracking_systems` as bg 
                LEFT JOIN `user_bug_tracking_accounts` as ubt 
                on bg.id = ubt.service_id and ubt.user_id = :userId';

        return $this->getEntityManager()->getConnection()->fetchAll($query,['userId' => $userId]);
    }
}
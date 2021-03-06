<?php

namespace BooksBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AccountL1Repository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AccountL1Repository extends EntityRepository
{
	public function findByForm($enterprise, $data)
	{
		$query = $this->getEntityManager()
            ->createQuery(
                'SELECT a1 FROM BooksBundle:AccountL1 a1
                INNER JOIN a1.accountsL2 a2
                INNER JOIN a2.accountsL3 a3
                INNER JOIN a3.vouchers v
                WHERE a1.enterprise = :enterprise
                AND v.state = :state
                AND v.date >= :date1
                AND v.date <= :date2
                '
            )->setParameters(array('enterprise'=>$enterprise->getId(),'state'=>$data['state'],'date1'=>$data['from'],'date2'=>$data['until']));
     
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
	}
}

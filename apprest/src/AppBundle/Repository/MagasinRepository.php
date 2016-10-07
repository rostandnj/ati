<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Antenne;

/**
 * MagasinRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MagasinRepository extends \Doctrine\ORM\EntityRepository
{
	public function getActiveMagasin($antenne)
	{
		$qb = $this->createQueryBuilder('m')
				   ->leftJoin('m.stocks','s')
                   ->addSelect('s')
                   ->leftJoin('m.antenne','a')
                   ->addSelect('a')
				   ->Where('m.antenne = :mag')
				   ->andWhere('m.actif = :stat')
				   ->setParameter('mag', $antenne)
				   ->setParameter('stat', 1);


				   return $qb->getQuery()
            ->execute();
	}
}

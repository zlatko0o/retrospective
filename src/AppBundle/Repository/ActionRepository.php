<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Team;
use Doctrine\ORM\EntityRepository;

class ActionRepository extends EntityRepository
{
	public function getAllActionsByTeam( Team $team )
	{
		return $this->getEntityManager()
			->createQueryBuilder()
			->select( 'a' )
			->from( 'AppBundle:Action', 'a' )
			->join( 'a.meeting', 'm' )
			->join( 'm.author', 'u' )
			->where( 'u.team = :team' )
			->setParameter( 'team', $team )
			->orderBy( 'a.id', 'DESC' )
			->getQuery()
			->getResult();
	}
}